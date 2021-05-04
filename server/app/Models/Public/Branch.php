<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model {
    use HasFactory;

    protected $connection = 'system';
    protected $fillable = ['company_id', 'email', 'country_id', 'state', 'city', 'address'];
}
