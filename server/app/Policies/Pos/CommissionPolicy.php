<?php

namespace App\Policies\Pos;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Helpers\AccountVerification;

class CommissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
