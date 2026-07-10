<?php

namespace App\Enums;

enum DonorOutcomeStatus: string
{
    case Completed = 'completed';
    case Rescheduled = 'rescheduled';
    case NotCompleted = 'not_completed';
}
