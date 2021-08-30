<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointOfSale extends Model {
    use SoftDeletes;

    protected $fillable = ['branch_id', 'ptoVta', 'name', 'short_name', 'status'];

    public function branch(){
        return $this->belongsTo('App\Models\Private\Branch');
    }
}
