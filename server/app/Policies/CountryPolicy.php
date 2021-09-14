<?php

namespace App\Policies;

use App\Models\Public\Country;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function showAll(User $user, Country $country, $perm=null) {
        
        dd($user);

        dd($user->roles->capabilities);
        if ($user->cannot($perm, $country)){
            return false;
        } else {
            return true;
        }

        return $user->id > 0;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Country  $country
     * @return mixed
     */
    public function view(User $user, Country $country) {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user) {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Country  $country
     * @return mixed
     */
    public function update(User $user, Country $country) {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Country  $country
     * @return mixed
     */
    public function delete(User $user, Country $country) {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Country  $country
     * @return mixed
     */
    public function restore(User $user, Country $country) {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Public\Country  $country
     * @return mixed
     */
    public function forceDelete(User $user, Country $country) {
        //
    }
}
