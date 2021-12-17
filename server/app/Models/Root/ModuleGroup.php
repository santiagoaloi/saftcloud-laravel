<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleGroup extends Model {
    use SoftDeletes;

    protected $fillable = ['id', 'module_group_id', 'name', 'icon', 'ordering'];

    public function moduleGroup(){
        return $this->belongsTomany('App\Models\Pos\ModuleGroup');
    }

    public function module(){
        return $this->hasmany('App\Models\GeneralConfig\Module');
    }
}
