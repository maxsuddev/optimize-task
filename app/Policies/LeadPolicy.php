<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{

    public function permission(User $user, Lead $lead): bool
    {
        return $user->id === $lead->user_id;
    }


}