<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model {
    use SoftDeletes;

    public function products(){
        return $this->belongsToMany('App\Models\Pos\Product');
    }
}
