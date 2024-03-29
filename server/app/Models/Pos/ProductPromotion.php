<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPromotion extends Model {
    use SoftDeletes;

    protected $fillable = [];

    public function Branch(){
        return $this->belongsTo('App\Models\Private\Branch');
    }

    public function product(){
        return $this->belongsTo('App\Models\Pos\Product');
    }
}
