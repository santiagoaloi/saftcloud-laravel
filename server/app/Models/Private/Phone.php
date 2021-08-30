<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model {
    use SoftDeletes;

    protected $fillable = ['name', 'country_code', 'phone_number'];

    public function phoneable(){
        return $this->MorphTo();
    }

    public function entity(){
        return $this->belongsTo('App\Models\Private\Entity');
    }
}
