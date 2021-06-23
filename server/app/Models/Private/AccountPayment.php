<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountPayment extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['account_id', 'amount'];
}
