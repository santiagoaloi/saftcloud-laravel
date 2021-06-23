<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['entity_id', 'bar_code', 'sku', 'category_id', 'family_id', 'brand_id', 'product_name', 
    'quantity', 'unimed_id', 'cost_net', 'cost_untaxed', 'iva_id', 'mkup_id', 'price', 'commission_id', 'stock', 
    'inventory', 'can_have_promotion', 'product_promotion_id ', 'cost_net_last_record', 'cost_untaxed_last_record', 
    'id_iva_last_record', 'mkup_id_last_record', 'price_last_record', 'avatar', 'incremental_type'];
}
