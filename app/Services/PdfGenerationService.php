<?php

namespace App\Services;

use App\Models\Donor;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerationService
{
    public function supports(Donor $donor): bool
    {
        return view()->exists('pdf-templates.'.strtolower($donor->assignedHospital->code));
    }

    public function generate(Donor $donor): string
    {
        $template = 'pdf-templates.'.strtolower($donor->assignedHospital->code);

        $data = $this->normalize($donor->data, $donor->assignedHospital->code);

        $pdf = Pdf::loadView($template, [
            'donor' => $donor,
            'data' => $data,
        ]);

        $pdf->setOption('isRemoteEnabled', true);

        return $pdf->output();
    }

    private function normalize(array $data, string $hospitalCode): array
    {
        return match (strtolower($hospitalCode)) {
            'pgh' => $this->forPgh($data),
            'redcross' => $this->forRedCross($data),
            'umc' => $this->forUmc($data),
            'vmmc' => $this->forVmmc($data),
            'eacmed' => $this->forEacMed($data),
            default => $data,
        };
    }

    private function forPgh(array $data): array
    {
        return [
            'personal' => [
                'surname' => $data['surname'] ?? '',
                'first_name' => $data['given_name'] ?? '',
                'middle_name' => $data['middle_name'] ?? '',
                'age' => $data['age'] ?? '',
                'gender' => $data['sex'] === 'male' ? 'Male' : ($data['sex'] === 'female' ? 'Female' : ($data['sex'] ?? '')),
                'birthdate' => $data['birthdate'] ?? '',
                'birthplace' => '',
                'civil_status' => ucfirst($data['civil_status'] ?? ''),
                'nationality' => '',
                'house_no' => $data['house_no'] ?? '',
                'street' => $data['street'] ?? '',
                'subdivision' => $data['subdivision'] ?? '',
                'barangay' => $data['barangay'] ?? '',
                'city' => $data['city_province'] ?? '',
                'province' => $data['city_province'] ?? '',
                'zip_code' => '',
                'telephone' => $data['contact_number'] ?? '',
                'occupation' => $data['occupation'] ?? '',
                'donation_count' => '',
                'last_donation_details' => '',
                'patient_name' => $data['representative_full_name'] ?? '',
                'case_no' => '',
                'dept_ward' => '',
                'relationship' => '',
            ],
        ];
    }

    private function forRedCross(array $data): array
    {
        return [
            'surname' => $data['surname'] ?? '',
            'first_name' => $data['given_name'] ?? '',
            'middle_name' => $data['middle_name'] ?? '',
            'birthdate' => $data['birthdate'] ?? '',
            'age' => $data['age'] ?? '',
            'civil_status' => ucfirst($data['civil_status'] ?? ''),
            'sex' => $data['sex'] === 'male' ? 'Male' : ($data['sex'] === 'female' ? 'Female' : ($data['sex'] ?? '')),
            'address_house_no' => $data['house_no'] ?? '',
            'address_street' => $data['street'] ?? '',
            'address_barangay' => $data['barangay'] ?? '',
            'address_town' => $data['city_province'] ?? '',
            'address_province' => $data['city_province'] ?? '',
            'address_zip' => '',
            'nationality' => '',
            'religion' => '',
            'education' => '',
            'occupation' => $data['occupation'] ?? '',
            'telephone_no' => $data['contact_number'] ?? '',
            'mobile_no' => $data['contact_number'] ?? '',
            'email' => $data['email'] ?? '',
        ];
    }

    private function forUmc(array $data): array
    {
        $address = trim(implode(', ', array_filter([
            $data['house_no'] ?? '',
            $data['street'] ?? '',
            $data['subdivision'] ?? '',
            $data['barangay'] ?? '',
            $data['city_province'] ?? '',
        ])));

        return [
            'personal' => [
                'surname' => $data['surname'] ?? '',
                'first_name' => $data['given_name'] ?? '',
                'middle_name' => $data['middle_name'] ?? '',
                'age' => $data['age'] ?? '',
                'gender' => $data['sex'] === 'male' ? 'Male' : ($data['sex'] === 'female' ? 'Female' : ($data['sex'] ?? '')),
                'birthdate' => $data['birthdate'] ?? '',
                'civil_status' => match ($data['civil_status'] ?? '') {
                    'single' => 'Single',
                    'married' => 'Married',
                    'divorced' => 'Separated',
                    'widowed' => 'Widow',
                    default => $data['civil_status'] ?? '',
                },
                'address' => $address,
                'occupation' => $data['occupation'] ?? '',
                'business_address' => '',
                'patient_name' => $data['representative_full_name'] ?? '',
                'cellphone' => $data['contact_number'] ?? '',
                'nationality' => '',
                'telephone' => '',
            ],
        ];
    }

    private function forVmmc(array $data): array
    {
        return [
            'personal' => [
                'surname' => $data['surname'] ?? '',
                'given_name' => $data['given_name'] ?? '',
                'middle_name' => $data['middle_name'] ?? '',
                'birthdate' => $data['birthdate'] ?? '',
                'sex' => $data['sex'] === 'male' ? 'Male' : ($data['sex'] === 'female' ? 'Female' : ($data['sex'] ?? '')),
                'civil_status' => $data['civil_status'] ?? '',
                'occupation' => $data['occupation'] ?? '',
                'house_no' => $data['house_no'] ?? '',
                'street' => $data['street'] ?? '',
                'subdivision' => $data['subdivision'] ?? '',
                'barangay' => $data['barangay'] ?? '',
                'city_province' => $data['city_province'] ?? '',
                'email' => $data['email'] ?? '',
                'contact_number' => $data['contact_number'] ?? '',
            ],
            'history' => [],
            'section_a' => [],
            'section_b' => [],
            'section_c' => [],
            'section_d' => [],
            'section_e' => [],
        ];
    }

    private function forEacMed(array $data): array
    {
        return [
            'facility_name' => 'Emilio Aguinaldo College Medical Center Cavite',
            'facility_address' => 'Brgy. Salitran II, City of Dasmariñas, Cavite',
            'facility_contact' => '(046) 416-3010',
            'facility_department' => 'Department of Laboratory Medicine - Blood Bank Section',
            'form_date' => now()->format('m/d/Y'),
            'personal' => [
                'last_name' => $data['surname'] ?? '',
                'first_name' => $data['given_name'] ?? '',
                'middle_name' => $data['middle_name'] ?? '',
                'birthdate' => $data['birthdate'] ?? '',
                'age' => $data['age'] ?? '',
                'gender' => $data['sex'] === 'male' ? 'Male' : ($data['sex'] === 'female' ? 'Female' : ($data['sex'] ?? '')),
                'civil_status' => match ($data['civil_status'] ?? '') {
                    'single' => 'Single',
                    'married' => 'Married',
                    'divorced' => 'Separated',
                    'widowed' => 'Widowed',
                    default => $data['civil_status'] ?? '',
                },
                'contact_no' => $data['contact_number'] ?? '',
                'email' => $data['email'] ?? '',
                'nationality' => '',
                'occupation' => $data['occupation'] ?? '',
                'address_street' => trim(implode(', ', array_filter([$data['house_no'] ?? '', $data['street'] ?? '', $data['subdivision'] ?? '']))),
                'address_barangay' => $data['barangay'] ?? '',
                'address_town' => '',
                'address_city' => $data['city_province'] ?? '',
                'address_province' => $data['city_province'] ?? '',
                'address_zip_code' => '',
            ],
        ];
    }
}
