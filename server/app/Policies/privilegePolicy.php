<?php

namespace App\Policies;

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

    public function store($capability) {
        $user = Auth::user();
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
    public function show($capability) {
        $user = Auth::user();
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

     public function showAll($capability) {
        $user = Auth::user();
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function showTrashed($capability) {
        $user = Auth::user();
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

    public function recoveryTrashed($capability) {
        $user = Auth::user();
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
    public function update($capability) {
        $user = Auth::user();
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function updateAll($capability) {
        $user = Auth::user();
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
    public function destroy($capability) {
        $user = Auth::user();
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
    public function forceDelete($capability) {
        $user = Auth::user();
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function attach($capability) {
        $user = Auth::user();
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function detach($capability) {
        $user = Auth::user();
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function sync($capability) {
        $user = Auth::user();
        $capabilities = getRolCapabilities($user);

        if(in_array($capability, $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }
}
