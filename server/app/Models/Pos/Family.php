<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model {
    use SoftDeletes;

    public function products(){
        return $this->belongsTo('App\Models\Pos\Product');
    }

    public function category(){
        return $this->belongsTo('App\Models\Pos\Category');
    }
}
