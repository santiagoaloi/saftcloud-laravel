<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model {
    use HasFactory;
    protected $fillable = ['email', 'owner_name', 'owner_surname', 'descripcion', 'account_telephone'];
}
