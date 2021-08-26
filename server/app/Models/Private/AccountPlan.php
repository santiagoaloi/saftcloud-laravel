<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountPlan extends Model {
    use SoftDeletes;

    protected $fillable = ['users', 'modules', 'locations', 'cash_registers'];

    public function Account(){
        return $this->belongsTo('App\Models\Private\Account');
    }
}
