<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    use HasFactory;

    protected $fillable = ['nombre', 'name', 'iso2', 'iso3', 'phone_code'];
}
