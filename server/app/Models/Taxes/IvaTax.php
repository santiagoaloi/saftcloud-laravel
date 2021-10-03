<?php

namespace App\Models\Taxes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IvaTax extends Model {
    use SoftDeletes;

    protected $fillable = ['country_id', 'code', 'name', 'value'];

    public function product(){
        return $this->belongsToMany('App\Models\Pos\Product');
    }
}
