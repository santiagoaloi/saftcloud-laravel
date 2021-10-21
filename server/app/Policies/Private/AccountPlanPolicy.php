<?php

namespace App\Policies\Private;

use App\Models\User;
use App\Models\Private\AccountPlan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Private\UserController;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Helpers\AccountVerification;

class AccountPlanPolicy {
    use HandlesAuthorization;
    
    public function store() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.store', $capabilities) OR AccountVerification::checkRootRole()) {
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
    public function show() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.show', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

     public function showAll() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.showAll', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function showTrashed() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.showTrashed', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

        /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\AccountPlan  $AccountPlan
     * @return mixed
     */

    public function restore() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.restore', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\AccountPlan  $AccountPlan
     * @return mixed
     */
    public function update() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.update', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function updateAll() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.updateAll', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\AccountPlan  $AccountPlan
     * @return mixed
     */
    public function destroy() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.destroy', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\AccountPlan  $AccountPlan
     * @return mixed
     */
    public function forceDelete() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('AccountPlan.forceDelete', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }
}
