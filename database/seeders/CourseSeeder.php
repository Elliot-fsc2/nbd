<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['name' => 'Bachelor of Science in Computer Science', 'department_id' => 1],
            ['name' => 'Bachelor of Science in Information Technology', 'department_id' => 1],
            ['name' => 'Bachelor of Science in Computer Engineering', 'department_id' => 1],
            ['name' => 'Bachelor of Science in Business Administration', 'department_id' => 2],
            ['name' => 'Bachelor of Science in Business Administration - Financial Management', 'department_id' => 2],
            ['name' => 'Bachelor of Science in Business Administration - Marketing Management', 'department_id' => 2],
            ['name' => 'Bachelor of Science in Office Administration', 'department_id' => 2],
            ['name' => 'Bachelor of Science in Customs Administration', 'department_id' => 2],
            ['name' => 'Bachelor of Arts in Communication', 'department_id' => 3],
            ['name' => 'Bachelor of Science in Psychology', 'department_id' => 3],
            ['name' => 'Bachelor of Science in Secondary Education - English', 'department_id' => 3],
            ['name' => 'Bachelor of Science in Secondary Education - Mathematics', 'department_id' => 3],
            ['name' => 'Bachelor of Science in Secondary Education - Filipino', 'department_id' => 3],
            ['name' => 'Bachelor of Science in Secondary Education - Social Studies', 'department_id' => 3],
            ['name' => 'Bachelor of Science in Architecture', 'department_id' => 6],
            ['name' => 'Bachelor of Science in Office Management', 'department_id' => 2],
            ['name' => 'Bachelor of Science in Entrepreneurship', 'department_id' => 2],
            ['name' => 'Bachelor of Science in Criminology', 'department_id' => 4],
            ['name' => 'Bachelor of Science in Hospitality Management', 'department_id' => 5],
            ['name' => 'Bachelor of Science in Tourism Management', 'department_id' => 5],
            ['name' => 'Bachelor of Science in Electronics Engineering', 'department_id' => 7],
            ['name' => 'Bachelor of Science in Industrial Engineering', 'department_id' => 7],
            ['name' => 'Bachelor of Science in Accountancy', 'department_id' => 8],
            ['name' => 'Bachelor of Science in Management Accounting', 'department_id' => 8],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
