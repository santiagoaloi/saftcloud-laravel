<?php

namespace App\Policies\Roles;

use App\Models\User;
use App\Models\Roles\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Private\UserController;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy {
    use HandlesAuthorization;
    public function store() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Role.store', $capabilities)){
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

        if(in_array('Role.show', $capabilities)){
            return true;
        }
        return false;
    }

     public function showAll() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Role.showAll', $capabilities)){
            return true;
        }
        return false;
    }

    public function showTrashed() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Role.showTrashed', $capabilities)){
            return true;
        }
        return false;
    }

        /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Role  $Role
     * @return mixed
     */

    public function restore(User $user, Role $Role) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Role.restore', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Role  $Role
     * @return mixed
     */
    public function update(User $user, Role $Role) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Role.update', $capabilities)){
            return true;
        }
        return false;
    }

    public function updateAll(User $user, Role $Role) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Role.updateAll', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Role  $Role
     * @return mixed
     */
    public function destroy(User $user, Role $Role) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Role.destroy', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Role  $Role
     * @return mixed
     */
    public function forceDelete(User $user, Role $Role) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Role.forceDelete', $capabilities)){
            return true;
        }
        return false;
    }
}