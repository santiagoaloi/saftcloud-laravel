<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentGroup extends Model {
    use SoftDeletes;

    protected $fillable = ['component_group_id', 'name', 'icon', 'ordering'];

    public function componentGroup(){
        return $this->belongsTomany('App\Models\Pos\ComponentGroup');
    }

    public function components(){
        return $this->hasmany('App\Models\GeneralConfig\Component');
    }
}
