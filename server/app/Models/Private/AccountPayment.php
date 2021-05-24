<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPayment extends Model {
    use HasFactory;

    protected $fillable = ['account_id', 'amount'];
}
