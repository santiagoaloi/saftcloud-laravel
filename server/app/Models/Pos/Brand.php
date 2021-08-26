<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model {
    use SoftDeletes;

    public function products(){
        return $this->hasMany('App\Models\Pos\Product');
    }
}
