<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountPayment extends Model {
    use SoftDeletes;

    protected $fillable = ['account_id', 'amount'];

    public function Account(){
        return $this->belongsTo('App\Models\Private\Account');
    }
}
