<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    use HasFactory;

    protected $connection = 'system';
    protected $fillable = ['account_id', 'name', 'alias', 'country_id', 'state', 'city', 'address'];
}
