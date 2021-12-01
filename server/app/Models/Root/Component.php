<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model {
    use SoftDeletes;

    protected $fillable = ['component_group_id', 'name', 'config', 'config_settings', 'status'];

    public function componentGroup(){
        return $this->belongsTo('App\Models\Pos\ComponentGroup');
    }

    public function rootAccount(){
        return $this->belongsToMany('App\Models\Private\RootAccount');
    }

    public function role(){
        return $this->belongsToMany('App\Models\Roles\Role');
    }

    public function branch(){
        return $this->belongsToMany('App\Models\Private\Branch');
    }
}
