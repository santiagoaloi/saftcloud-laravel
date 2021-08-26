<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LookUpListValue extends Model {
    use SoftDeletes;

    protected $fillable = ['look_up_list_id', 'name', 'value'];

    public function LookUpList(){
        return $this->belongsTo('App\Models\Private\LookUpList');
    }

    public function entity(){
        return $this->belongsTo('App\Models\Private\entity');
    }
}
