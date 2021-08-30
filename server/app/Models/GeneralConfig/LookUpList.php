<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LookUpList extends Model {
    use SoftDeletes;

    protected $fillable = ['name'];

    public function LookUpListValues(){
        return $this->hasMany('App\Models\GeneralConfig\LookUpListValue');
    }
}
