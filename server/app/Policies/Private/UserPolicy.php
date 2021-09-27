<?php

namespace App\Policies\Private;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Private\UserController;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
    use HandlesAuthorization;

    public function store(user $user) {
        if($user->email == 'santiagoaloi@gmail.com') {
            return true;
        }
        return false;

        // $userC = New UserController;
        // $capabilities = $userC->getRolCapabilities($user);

        // if(in_array('User.store', $capabilities)){
        //     return true;
        // }
        // return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function show(user $user) {
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('User.show', $capabilities)){
            return true;
        }
        return false;
    }

     public function showAll(user $user) {
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('User.showAll', $capabilities)){
            return true;
        }
        return false;
    }

    public function showTrashed(user $user, $request) {
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('User.showTrashed', $capabilities)){
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

    public function restore(User $user, $request) {
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('User.restore', $capabilities)){
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
    public function update(User $user, $request) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('User.update', $capabilities)){
            return true;
        }
        return false;
    }

    public function updateAll(User $user, $request) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('User.updateAll', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\User  $User
     * @return mixed
     */
    public function destroy(User $user, $request) {
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('User.destroy', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\User  $User
     * @return mixed
     */
    public function forceDelete(User $user, $request) {
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('User.forceDelete', $capabilities)){
            return true;
        }
        return false;
    }
}
