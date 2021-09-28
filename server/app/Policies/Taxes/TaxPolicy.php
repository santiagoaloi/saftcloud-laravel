<?php

namespace App\Policies\Taxes;

use App\Models\User;
use App\Models\Taxes\Tax;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Private\UserController;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Helpers\AccountVerification;

class TaxPolicy {
    use HandlesAuthorization;

    public function store() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Tax.store', $capabilities) OR AccountVerification::checkRootRole()) {
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

        if(in_array('Tax.show', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

     public function showAll() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Tax.showAll', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function showTrashed() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Tax.showTrashed', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

        /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Tax  $Tax
     * @return mixed
     */

    public function restore(User $user, Tax $Tax) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Tax.restore', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Tax  $Tax
     * @return mixed
     */
    public function update(User $user, Tax $Tax) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Tax.update', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    public function updateAll(User $user, Tax $Tax) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Tax.updateAll', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Tax  $Tax
     * @return mixed
     */
    public function destroy(User $user, Tax $Tax) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Tax.destroy', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Tax  $Tax
     * @return mixed
     */
    public function forceDelete(User $user, Tax $Tax) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Tax.forceDelete', $capabilities) OR AccountVerification::checkRootRole()) {
            return true;
        }
        return false;
    }
}
