<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model {
    use SoftDeletes;

    protected $cast = [];
    protected $fillable = ['license', 'account_plan_id', 'payment_status', 'email', 'doc_type_id', 'doc_number', 'name'];

    public function AccountPlan(){
        return $this->hasOne('App\Models\AccountPlan');
    }

    public function AccountPayments(){
        return $this->hasMany('App\Models\Private\AccountPayment');
    }

    public function entity(){
        return $this->hasOne('App\Models\Private\Entity');
    }
}
