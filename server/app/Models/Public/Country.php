<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model {
    use SoftDeletes;

    protected $fillable = ['nombre', 'name', 'iso2', 'iso3', 'phone_code'];

    public function states(){
        return $this->hasmany('App\Models\GeneralConfig\Public\state');
    }

}
