<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capability extends Model {
    use SoftDeletes;

    protected $fillable = ['name', 'description'];
    public function user(){
        return $this->belongsToMany('App\Models\User');
    }

    public function role(){
       return $this->belongsToMany('App\Models\Roles\Role');
    }
}
