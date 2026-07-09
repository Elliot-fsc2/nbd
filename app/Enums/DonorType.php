<?php

namespace App\Enums;

enum DonorType: string
{
    case Student = 'student';
    case Employee = 'employee';
    case Representative = 'representative';
}
