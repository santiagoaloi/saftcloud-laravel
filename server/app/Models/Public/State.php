<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model {
    use SoftDeletes;

    protected $fillable = ['country_id', 'name'];
    
    public function country(){
        return $this->belongsTo('App\Models\Public\country');
    }

    public function address(){
        return $this->hasmany('App\Models\GeneralConfig\Private\address');
    }
}
