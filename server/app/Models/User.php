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

    public function entity(){
        return $this->belongsTo('App\Models\Private\Entity');
    }

    public function userSettings(){
        return $this->hasOne('App\Models\Private\UserSettings');
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Roles\Role');
    }

    public function capabilities(){
        return $this->belongsToMany('App\Models\Roles\Capability');
    }
}
