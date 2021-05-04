<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model {
    use HasFactory;
    protected $connection = 'mysql';
    protected $fillable = ['license', 'client_type', 'account_name', 'owner_first_name', 'owner_last_name', 'email', 'phone_code', 'phone_number'];
}
