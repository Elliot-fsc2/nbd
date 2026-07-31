<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Department;
use App\Models\Donor;
use App\Models\Hospital;
use App\Models\User;
use App\Services\PdfGenerationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
    Queue::fake();
});

function seededCourse(): Course
{
    return Course::first() ?? Course::create([
        'name' => 'Nursing',
        'department_id' => Department::first()?->id,
    ]);
}

function seededHospital(string $code = 'eacmed'): Hospital
{
    return Hospital::where('code', $code)->first() ?? Hospital::create([
        'name' => match ($code) {
            'eacmed' => 'Emilio Aguinaldo College Medical Center',
            'VMMC' => 'Veterans Memorial Medical Center',
            'PGH' => 'Philippine General Hospital',
            'RedCross' => 'Red Cross',
            'UMC' => 'De la Salle University Medical Center',
            default => 'Test Hospital',
        },
        'code' => $code,
    ]);
}

function actingAsStaff(): void
{
    $staff = User::factory()->create(['role' => UserRole::Staff]);
    test()->actingAs($staff);
}

test('public donor form submits and creates a non-walk-in donor', function () {
    $course = seededCourse();
    seededHospital();

    $response = $this->post(route('register'), [
        'donor_type' => 'student',
        'id_number' => null,
        'surname' => 'Cotton',
        'given_name' => 'Lydia',
        'middle_name' => 'Alisa',
        'birthdate' => '1970-07-29',
        'age' => '55',
        'sex' => 'male',
        'civil_status' => 'single',
        'blood_type' => 'A+',
        'occupation' => 'Engineer',
        'house_no' => '123',
        'street' => 'Rizal St',
        'barangay' => 'Brgy San Isidro',
        'city_province' => 'Dasmariñas, Cavite',
        'email' => 'publictest'.uniqid().'@gmail.com',
        'contact_number' => '09123123123',
        'course_id' => (string) $course->id,
        'house_heroes' => 'makabayan',
        'consent' => true,
    ]);

    $response->assertRedirect(route('home'));

    $donor = Donor::where('full_name', 'Cotton, Lydia Alisa')->first();
    expect($donor)->not->toBeNull()
        ->and($donor->is_walk_in)->toBe(false)
        ->and($donor->data['surname'])->toBe('Cotton')
        ->and($donor->email)->not->toBe('');
});

test('walk-in donor store creates a walk-in donor', function () {
    seededHospital();
    seededCourse();
    actingAsStaff();

    $hospital = Hospital::first();

    $response = $this->post(route('staff.donors.store'), [
        'full_name' => 'Walkin Test Person',
        'donor_type' => 'student',
        'hospital_id' => (string) $hospital->id,
        'id_number' => '2024-00123',
        'course_id' => (string) Course::first()->id,
        'house_heroes' => 'makatao',
        'instructor_name' => 'Prof Test',
    ]);

    $response->assertRedirect();

    $donor = Donor::where('full_name', 'Walkin Test Person')->first();
    expect($donor)->not->toBeNull()
        ->and($donor->is_walk_in)->toBe(true)
        ->and($donor->id_number)->toBe('2024-00123');
});

test('walk-in representative store captures representative details', function () {
    seededHospital();
    seededCourse();
    actingAsStaff();

    $hospital = Hospital::first();

    $response = $this->post(route('staff.donors.store'), [
        'full_name' => 'Walkin Rep Person',
        'donor_type' => 'representative',
        'hospital_id' => (string) $hospital->id,
        'id_number' => '2024-00999',
        'representative_full_name' => 'Juan Dela Cruz',
        'course_id' => (string) Course::first()->id,
        'house_heroes' => 'makabayan',
        'instructor_name' => 'Prof Test',
    ]);

    $response->assertRedirect();

    $donor = Donor::where('full_name', 'Walkin Rep Person')->first();
    expect($donor)->not->toBeNull()
        ->and($donor->is_walk_in)->toBe(true)
        ->and($donor->donor_type?->value)->toBe('representative')
        ->and($donor->data['representative_full_name'])->toBe('Juan Dela Cruz')
        ->and($donor->data['house_heroes'])->toBe('makabayan');
});

test('pdf generation works for both public and walk-in donors on eacmed template', function () {
    $hospital = seededHospital('eacmed');
    $service = app(PdfGenerationService::class);

    $publicDonor = Donor::create([
        'tracking_code' => 'PUBLIC-TEST',
        'donor_type' => 'student',
        'full_name' => 'Cotton, Lydia Alisa',
        'email' => 'publictest@gmail.com',
        'id_number' => '12345',
        'contact_number' => '09123123123',
        'assigned_hospital_id' => $hospital->id,
        'is_walk_in' => false,
        'data' => [
            'surname' => 'Cotton',
            'given_name' => 'Lydia',
            'middle_name' => 'Alisa',
            'birthdate' => '1970-07-29',
            'age' => '55',
            'sex' => 'male',
            'civil_status' => 'single',
            'blood_type' => 'A+',
            'occupation' => 'Engineer',
            'house_no' => '123',
            'street' => 'Rizal St',
            'barangay' => 'Brgy San Isidro',
            'city_province' => 'Dasmariñas, Cavite',
            'email' => 'publictest@gmail.com',
            'contact_number' => '09123123123',
            'house_heroes' => 'makabayan',
        ],
    ]);

    $walkInDonor = Donor::create([
        'tracking_code' => 'WALKIN-TEST',
        'donor_type' => 'student',
        'full_name' => 'Walkin Test Person',
        'email' => '',
        'assigned_hospital_id' => $hospital->id,
        'is_walk_in' => true,
        'data' => [
            'course_id' => '23',
            'house_heroes' => 'makatao',
            'instructor_name' => 'Prof Test',
        ],
    ]);

    foreach ([$publicDonor, $walkInDonor] as $donor) {
        $pdf = $service->generate($donor);

        expect($pdf)->toBeString()
            ->and(strlen($pdf))->toBeGreaterThan(1000)
            ->and(str_starts_with($pdf, '%PDF'))->toBeTrue();
    }
});

test('walk-in donor form endpoint serves inline or attachment pdf', function () {
    seededHospital('eacmed');
    actingAsStaff();

    $donor = Donor::create([
        'tracking_code' => 'WALKIN-INLINE',
        'donor_type' => 'student',
        'full_name' => 'Inline Test',
        'email' => '',
        'assigned_hospital_id' => Hospital::first()->id,
        'is_walk_in' => true,
        'data' => ['course_id' => '23', 'house_heroes' => 'makatao'],
    ]);

    $response = $this->get(route('staff.donors.form', $donor).'?inline=1');
    $response->assertOk();
    expect($response->headers->get('Content-Disposition'))->toContain('inline');

    $response = $this->get(route('staff.donors.form', $donor));
    $response->assertOk();
    expect($response->headers->get('Content-Disposition'))->toContain('attachment');
});

test('staff donors index filters by walk_in', function () {
    $hospital = seededHospital('eacmed');
    actingAsStaff();

    Donor::create([
        'tracking_code' => 'WALK-FILTER-A',
        'donor_type' => 'student',
        'full_name' => 'Walk Filter Person',
        'email' => '',
        'assigned_hospital_id' => $hospital->id,
        'is_walk_in' => true,
        'data' => ['course_id' => '23', 'house_heroes' => 'makatao'],
    ]);

    Donor::create([
        'tracking_code' => 'ONLINE-FILTER-A',
        'donor_type' => 'student',
        'full_name' => 'Online Filter Person',
        'email' => 'onlinefilter@gmail.com',
        'assigned_hospital_id' => $hospital->id,
        'is_walk_in' => false,
        'data' => ['surname' => 'Filter', 'given_name' => 'Online'],
    ]);

    $walkInResponse = $this->get(route('staff.donors.index', ['walk_in' => 'walk_in']));
    $walkInResponse->assertOk();
    $walkInResponse->assertInertia(fn ($page) => $page->component('staff/donors/index')
        ->where('filters.walk_in', 'walk_in')
        ->has('donors.data', 1));

    $onlineResponse = $this->get(route('staff.donors.index', ['walk_in' => 'online']));
    $onlineResponse->assertOk();
    $onlineResponse->assertInertia(fn ($page) => $page->component('staff/donors/index')
        ->where('filters.walk_in', 'online')
        ->has('donors.data', 1));
});

test('staff donors export includes walk-in column', function () {
    $hospital = seededHospital('eacmed');
    actingAsStaff();

    Donor::create([
        'tracking_code' => 'WALK-EXPORT-A',
        'donor_type' => 'student',
        'full_name' => 'Walk Export Person',
        'email' => '',
        'assigned_hospital_id' => $hospital->id,
        'is_walk_in' => true,
        'data' => ['course_id' => '23', 'house_heroes' => 'makatao'],
    ]);

    $response = $this->get(route('staff.donors.export'));
    $response->assertOk();

    $csv = $response->streamedContent();
    $lines = array_map('str_getcsv', explode("\n", trim($csv)));

    expect($lines[0])->toContain('Walk-in');

    $walkInRows = array_filter($lines, fn ($line) => ($line[1] ?? '') === 'WALK-EXPORT-A');
    $walkInRow = array_values($walkInRows)[0];

    $walkInColumn = array_search('Walk-in', $lines[0]);

    expect($walkInRow)->not->toBeNull()
        ->and($walkInColumn)->not->toBe(false)
        ->and($walkInRow[$walkInColumn])->toBe('Yes');
});
