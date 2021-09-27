<?php

namespace App\Policies\Pos;

use App\Models\User;
use App\Models\Pos\Brand;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Private\UserController;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy {
    use HandlesAuthorization;

    public function store() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Brand.store', $capabilities)){
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

        if(in_array('Brand.show', $capabilities)){
            return true;
        }
        return false;
    }

     public function showAll() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Brand.showAll', $capabilities)){
            return true;
        }
        return false;
    }

    public function showTrashed() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Brand.showTrashed', $capabilities)){
            return true;
        }
        return false;
    }

        /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Brand  $Brand
     * @return mixed
     */

    public function restore(User $user, Brand $Brand) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Brand.restore', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Brand  $Brand
     * @return mixed
     */
    public function update(User $user, Brand $Brand) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Brand.update', $capabilities)){
            return true;
        }
        return false;
    }

    public function updateAll(User $user, Brand $Brand) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Brand.updateAll', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Brand  $Brand
     * @return mixed
     */
    public function destroy(User $user, Brand $Brand) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Brand.destroy', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Brand  $Brand
     * @return mixed
     */
    public function forceDelete(User $user, Brand $Brand) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('Brand.forceDelete', $capabilities)){
            return true;
        }
        return false;
    }
}