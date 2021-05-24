<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    use HasFactory;

    protected $fillable = ['entity_id', 'description', 'state_id', 'city', 'address'];
}
