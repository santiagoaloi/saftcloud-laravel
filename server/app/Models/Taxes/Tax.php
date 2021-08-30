<?php

namespace App\Models\Taxes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model {
    use SoftDeletes;

    protected $fillable = ['country_id', 'code', 'name', 'value'];

    public function products(){
        return $this->belongsToMany('App\Models\Pos\Product');
    }
}
