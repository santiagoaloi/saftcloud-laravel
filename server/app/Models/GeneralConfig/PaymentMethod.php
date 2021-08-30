<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model {
    use SoftDeletes;

    protected $fillable = ['branch_id', 'name', 'short_name'];

    public function Branch(){
        return $this->belongsTo('App\Models\Private\Branch');
    }
}
