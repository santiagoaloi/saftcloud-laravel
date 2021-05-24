<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model {
    use HasFactory;

    protected $connection = 'mysql';
    protected $fillable = ['company_id', 'email', 'country_id', 'state', 'city', 'address'];
}
