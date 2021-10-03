<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['entity_id', 'email', 'password', 'second_factor', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    public function userSetting(){
        return $this->hasOne('App\Models\Private\UserSetting');
    }

    public function entity(){
        return $this->belongsTo('App\Models\Private\Entity');
    }

    public function branch(){
        return $this->belongsToMany('App\Models\Private\Branch');
    }

    public function role(){
        return $this->belongsToMany('App\Models\Roles\Role');
    }

    public function capability(){
        return $this->belongsToMany('App\Models\Roles\Capability');
    }

    public function isAdmin(User $user){
        return $this->role->name('Admin');
    }

}
