<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $cast = [];
    protected $fillable = ['license', 'account_plan_id', 'payment_status', 'email', 'doc_type_id', 'doc_number', 'name'];
}
