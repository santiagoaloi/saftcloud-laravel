<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentType extends Model {
    use SoftDeletes;

    protected $fillable = ['country_id', 'name', 'short_name', 'value'];

    public function Account(){
        return $this->belongsToMany('App\Models\Private\RootAccount');
    }
}
