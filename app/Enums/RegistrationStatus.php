<?php

namespace App\Enums;

enum RegistrationStatus: string
{
    case Registered = 'registered';
    case CheckedIn = 'checked_in';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Skipped = 'skipped';
    case NoShow = 'no_show';
}
