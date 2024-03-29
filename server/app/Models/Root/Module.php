<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model {
    use SoftDeletes;

    protected $fillable = ['module_group_id', 'name', 'config', 'config_settings', 'status'];

    public function moduleGroup(){
        return $this->belongsTo('App\Models\Pos\ModuleGroup');
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
