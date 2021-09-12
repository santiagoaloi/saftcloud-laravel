<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capability extends Model {
    use SoftDeletes;

    protected $fillable = ['name'];

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

    public function roles(){
       return $this->belongsToMany('App\Models\Roles\Role');
    }
}