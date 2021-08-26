<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use SoftDeletes;

    protected $fillable = ['entity_id', 'bar_code', 'sku', 'category_id', 'family_id', 'brand_id', 'product_name', 
        'quantity', 'unimed_id', 'cost_net', 'cost_untaxed', 'iva_id', 'mkup_id', 'price', 'commission_id', 'stock', 
        'inventory', 'can_have_promotion', 'product_promotion_id ', 'cost_net_last_record', 'cost_untaxed_last_record', 
        'id_iva_last_record', 'mkup_id_last_record', 'price_last_record', 'avatar', 'incremental_type'
    ];

    public function price(){
        return $this->hasMany('App\Models\pos\Price');
    }

    public function ivaTaxes(){
        return $this->hasOne('App\Models\Taxes\IvaTaxes');
    }

    public function mkup(){
        return $this->hasOne('App\Models\pos\Mkup');
    }

    public function commision(){
        return $this->hasOne('App\Models\pos\Commission');
    }

    public function promotions(){
        return $this->hasOne('App\Models\pos\ProductPromotion');
    }

    public function branch(){
        return $this->belongsTo('App\Models\Private\Branch');
    }

    public function brands(){
        return $this->belongsTo('App\Models\Pos\Brands');
    }

    public function families(){
        return $this->belongsTo('App\Models\Pos\Family');
    }

    public function categories(){
        return $this->belongsTo('App\Models\Pos\Category');
    }

    public function measurementUnit(){
        return $this->hasOne('App\Models\Pos\MeasurementUnit');
    }
}
