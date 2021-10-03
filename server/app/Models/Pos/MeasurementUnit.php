<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasurementUnit extends Model {
    use SoftDeletes;

    public function product(){
        return $this->belongsToMany('App\Models\Pos\Product');
    }

    public function measurementUnitSystem(){
        return $this->belongsTo('App\Models\Pos\MeasurementUnitSystem');
    }
}
