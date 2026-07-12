<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::pluck('id', 'name');

        $courses = [
            ['name' => 'Bachelor of Science in Computer Science', 'department' => 'Computer Studies'],
            ['name' => 'Bachelor of Science in Information Technology', 'department' => 'Computer Studies'],
            ['name' => 'Bachelor of Science in Computer Engineering', 'department' => 'Computer Studies'],
            ['name' => 'Bachelor of Science in Business Administration', 'department' => 'Business Administration'],
            ['name' => 'Bachelor of Science in Business Administration - Financial Management', 'department' => 'Business Administration'],
            ['name' => 'Bachelor of Science in Business Administration - Marketing Management', 'department' => 'Business Administration'],
            ['name' => 'Bachelor of Science in Office Administration', 'department' => 'Business Administration'],
            ['name' => 'Bachelor of Science in Customs Administration', 'department' => 'Business Administration'],
            ['name' => 'Bachelor of Arts in Communication', 'department' => 'EdPsyComm'],
            ['name' => 'Bachelor of Science in Psychology', 'department' => 'EdPsyComm'],
            ['name' => 'Bachelor of Science in Secondary Education - English', 'department' => 'EdPsyComm'],
            ['name' => 'Bachelor of Science in Secondary Education - Mathematics', 'department' => 'EdPsyComm'],
            ['name' => 'Bachelor of Science in Secondary Education - Filipino', 'department' => 'EdPsyComm'],
            ['name' => 'Bachelor of Science in Secondary Education - Social Studies', 'department' => 'EdPsyComm'],
            ['name' => 'Bachelor of Science in Architecture', 'department' => 'Architecture'],
            ['name' => 'Bachelor of Science in Office Management', 'department' => 'Business Administration'],
            ['name' => 'Bachelor of Science in Entrepreneurship', 'department' => 'Business Administration'],
            ['name' => 'Bachelor of Science in Criminology', 'department' => 'Criminal Justice'],
            ['name' => 'Bachelor of Science in Hospitality Management', 'department' => 'HTMD'],
            ['name' => 'Bachelor of Science in Tourism Management', 'department' => 'HTMD'],
            ['name' => 'Bachelor of Science in Electronics Engineering', 'department' => 'Engineering'],
            ['name' => 'Bachelor of Science in Industrial Engineering', 'department' => 'Engineering'],
            ['name' => 'Bachelor of Science in Accountancy', 'department' => 'Accounting'],
            ['name' => 'Bachelor of Science in Management Accounting', 'department' => 'Accounting'],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate([
                'name' => $course['name'],
            ], [
                'department_id' => $departments[$course['department']],
            ]);
        }
    }
}
