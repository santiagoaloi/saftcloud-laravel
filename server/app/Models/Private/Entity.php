<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model {
    use SoftDeletes;

    protected $fillable = ['account_id', 'entity_type_id', 'first_name', 'last_name', 'iva_condition', 'doc_type_id', 
    'doc_num', 'ing_brutos', 'birthday'];

    public function account(){
        return $this->belongsTo('App\Models\Private\Account');
    }

    public function entityType(){
        return $this->hasmany('App\Models\GeneralConfig\LookUpListValue');
    }

    public function user(){
        return $this->hasOne('App\Models\User');
    }

    public function addresses(){
        return $this->morphMany('App\Models\Private\Address', 'addreseable');
    }

    public function phones(){
        return $this->morphMany('App\Models\Private\Phone', 'phoneable');
    }

    public function socials(){
        return $this->morphMany('App\Models\Private\Social', 'socialable');
    }
}
