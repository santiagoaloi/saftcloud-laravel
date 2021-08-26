<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {
    use SoftDeletes;

    protected $fillable = ['name', 'state_id', 'city', 'neighborhood', 'street', 'street_number', 'floor', 'streetX', 'streetY'];

    public function addreseable(){
        return $this->MorphTo();
    }

    public function entity(){
        return $this->belongsTo('App\Models\Private\Entity');
    }

    public function state(){
        return $this->belongsTo('App\Models\Public\state');
    }
}
