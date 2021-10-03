<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use SoftDeletes;

    public function product(){
        return $this->hasMany('App\Models\Pos\Product');
    }

    public function family(){
        return $this->hasMany('App\Models\Pos\Family');
    }
}
