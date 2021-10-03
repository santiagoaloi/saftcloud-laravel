<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model {
    use SoftDeletes;

    protected $fillable = ['root_account_id', 'entity_type_id', 'first_name', 'last_name', 'iva_condition_id', 'document_type_id', 
    'doc_number', 'ing_brutos_number', 'birthday'];

    public function rootAccount(){
        return $this->belongsTo('App\Models\Private\RootAccount');
    }

    public function entityType(){
        return $this->hasMany('App\Models\GeneralConfig\LookUpListValue');
    }

    public function ivaCondition(){
        return $this->belongsTo('App\Models\Taxes\IvaCondition');
    }

    public function user(){
        return $this->hasOne('App\Models\User');
    }

    public function branch(){
        return $this->hasMany('App\Models\Private\Branch');
    }

    public function address(){
        return $this->morphMany('App\Models\Private\Address', 'addreseable');
    }

    public function phone(){
        return $this->morphMany('App\Models\Private\Phone', 'phoneable');
    }

    public function social(){
        return $this->morphMany('App\Models\Private\Social', 'socialable');
    }
}
