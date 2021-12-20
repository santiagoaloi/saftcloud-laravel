<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RootAccount extends Model {
    use SoftDeletes;

    // protected $cast = [];
    protected $fillable = ['license', 'account_plan_id', 'payment_status', 'email', 'document_type_id', 'doc_number', 'name'];

    public function AccountPlan(){
        return $this->hasOne('App\Models\AccountPlan');
    }

    public function AccountPayment(){
        return $this->hasMany('App\Models\Private\AccountPayment');
    }

    public function entity(){
        return $this->hasMany('App\Models\Private\Entity');
    }

    public function documentType(){
        return $this->hasOne('App\Models\GeneralConfig\DocumentType');
    }

    public function component(){
        return $this->belongsToMany('App\Models\Root\Component');
    }
}
