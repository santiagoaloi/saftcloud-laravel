<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['entity_id', 'description', 'country_id', 'phone_number'];
}
