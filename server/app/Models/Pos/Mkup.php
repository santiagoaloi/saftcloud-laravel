<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mkup extends Model {
    use SoftDeletes;

    public function product(){
        return $this->belongsToMany('App\Models\Pos\Product');
    }
}
