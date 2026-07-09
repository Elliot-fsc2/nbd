<?php

namespace App\Enums;

enum DonorStatus: string
{
    case Registered = 'registered';
    case CheckedIn = 'checked_in';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Skipped = 'skipped';
}
