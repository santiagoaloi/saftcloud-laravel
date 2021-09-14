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
        return $this->belongsToMany('App\Models\GeneralConfig\User');
    }

    public function pointOfSales(){
        return $this->hasmany('App\Models\Private\PointOfSale');
    }

    public function paymentMethod(){
        return $this->hasMany('App\Models\GeneralConfig\PaymentMethod');
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
