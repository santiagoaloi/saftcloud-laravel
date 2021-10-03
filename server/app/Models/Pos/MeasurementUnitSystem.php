<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasurementUnitSystem extends Model {
    use SoftDeletes;

    public function branch(){
        return $this->belongsTo('App\Models\Private\Branch');
    }

    public function measurementUnit(){
        return $this->hasMany('App\Models\Pos\MeasurementUnit');
    }
}
