<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model {
    use HasFactory;

    protected $cast = [];
    protected $connection = 'mysql';
    protected $fillable = ['license', 'plan', 'name', 'email', 'payment_status', 'owner_first_name', 'owner_last_name', 'phone_code', 'phone_number'];
}
