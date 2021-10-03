<?php

namespace App\Models\Taxes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IvaCondition extends Model {
    use SoftDeletes;

    protected $fillable = ['country_id', 'name', 'short_name', 'value'];

    public function entity(){
        return $this->hasMany('App\Models\Private\Entity');
    }
}
