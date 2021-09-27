<?php

namespace App\Policies\Private;

use App\Models\User;
use App\Models\Private\RootAccount;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Private\UserController;
use Illuminate\Auth\Access\HandlesAuthorization;

class RootAccountPolicy {
    use HandlesAuthorization;

    public function store() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('RootAccount.store', $capabilities)){
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

        if(in_array('RootAccount.show', $capabilities)){
            return true;
        }
        return false;
    }

     public function showAll() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('RootAccount.showAll', $capabilities)){
            return true;
        }
        return false;
    }

    public function showTrashed() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('RootAccount.showTrashed', $capabilities)){
            return true;
        }
        return false;
    }

        /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\RootAccount  $RootAccount
     * @return mixed
     */

    public function restore(User $user, RootAccount $RootAccount) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('RootAccount.restore', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\RootAccount  $RootAccount
     * @return mixed
     */
    public function update(User $user, RootAccount $RootAccount) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('RootAccount.update', $capabilities)){
            return true;
        }
        return false;
    }

    public function updateAll(User $user, RootAccount $RootAccount) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('RootAccount.updateAll', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\RootAccount  $RootAccount
     * @return mixed
     */
    public function destroy(User $user, RootAccount $RootAccount) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('RootAccount.destroy', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\RootAccount  $RootAccount
     * @return mixed
     */
    public function forceDelete(User $user, RootAccount $RootAccount) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('RootAccount.forceDelete', $capabilities)){
            return true;
        }
        return false;
    }
}
