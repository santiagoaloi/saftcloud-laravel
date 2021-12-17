<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model {
    use SoftDeletes;

    protected $fillable = ['entity_id', 'email', 'description'];

    public function entity(){
        return $this->belongsTo('App\Models\Private\Entity');
    }

    public function user(){
        return $this->belongsToMany('App\Models\User');
    }

    public function pointOfSale(){
        return $this->hasmany('App\Models\Private\PointOfSale');
    }

    public function paymentMethod(){
        return $this->hasMany('App\Models\GeneralConfig\PaymentMethod');
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

    public function module(){
        return $this->belongsToMany('App\Models\Root\Module');
    }
}
