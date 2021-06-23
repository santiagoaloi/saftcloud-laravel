<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPromotion extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [];
}
