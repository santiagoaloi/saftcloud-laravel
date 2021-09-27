<?php

namespace App\Policies\Pos;

use App\Models\User;
use App\Models\Pos\MeasurementUnitSystem;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Private\UserController;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeasurementUnitSystemPolicy {
    use HandlesAuthorization;

    public function store() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('MeasurementUnitSystem.store', $capabilities)){
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

        if(in_array('MeasurementUnitSystem.show', $capabilities)){
            return true;
        }
        return false;
    }

     public function showAll() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('MeasurementUnitSystem.showAll', $capabilities)){
            return true;
        }
        return false;
    }

    public function showTrashed() {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('MeasurementUnitSystem.showTrashed', $capabilities)){
            return true;
        }
        return false;
    }

        /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\MeasurementUnitSystem  $MeasurementUnitSystem
     * @return mixed
     */

    public function restore(User $user, MeasurementUnitSystem $MeasurementUnitSystem) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('MeasurementUnitSystem.restore', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\MeasurementUnitSystem  $MeasurementUnitSystem
     * @return mixed
     */
    public function update(User $user, MeasurementUnitSystem $MeasurementUnitSystem) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('MeasurementUnitSystem.update', $capabilities)){
            return true;
        }
        return false;
    }

    public function updateAll(User $user, MeasurementUnitSystem $MeasurementUnitSystem) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('MeasurementUnitSystem.updateAll', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\MeasurementUnitSystem  $MeasurementUnitSystem
     * @return mixed
     */
    public function destroy(User $user, MeasurementUnitSystem $MeasurementUnitSystem) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('MeasurementUnitSystem.destroy', $capabilities)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\MeasurementUnitSystem  $MeasurementUnitSystem
     * @return mixed
     */
    public function forceDelete(User $user, MeasurementUnitSystem $MeasurementUnitSystem) {
        $user = Auth::user();
        $userC = New UserController;
        $capabilities = $userC->getRolCapabilities($user);

        if(in_array('MeasurementUnitSystem.forceDelete', $capabilities)){
            return true;
        }
        return false;
    }
}
