<?php

namespace App\Services;

use App\Models\Hospital;

class HospitalAssignmentService
{
    public function assign(): Hospital
    {
        return Hospital::withCount('donors')
            ->orderBy('donors_count')
            ->firstOrFail();
    }
}
