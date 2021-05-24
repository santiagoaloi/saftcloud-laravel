<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model {
    use HasFactory;

    protected $fillable = ['entity_id', 'description', 'phone_code', 'phone_number'];
}
