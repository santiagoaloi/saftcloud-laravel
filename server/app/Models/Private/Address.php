<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['entity_id', 'description', 'state_id', 'city', 'neighborhood', 'street', 'street_number', 'floor', 'streetX', 'streetY'];
}
