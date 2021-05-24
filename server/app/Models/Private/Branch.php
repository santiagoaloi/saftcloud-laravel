<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model {
    use HasFactory;

    protected $fillable = ['entity_id', 'address_id', 'phone_id', 'email', 'description', 'appBar', 'config', 'access', 'menu', 'itemOrder'];
}
