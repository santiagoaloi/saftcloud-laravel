<?php

namespace App\Policies;

use App\Models\User;
use App\Helpers\AccountVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class privilegePolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function store(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function show(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function showAll(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function showTrashed(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

        /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */

    public function recoveryTrashed(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function updateAll(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function destroy(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function forceDelete(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function attach(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function detach(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function sync(User $user, $capability) {
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }
}
