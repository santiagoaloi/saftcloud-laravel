<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model {
    use HasFactory;

    protected $fillable = ['account_id', 'person_type_id', 'first_name', 'last_name', 'iva_condition', 'doc_type', 'doc_num', 'ing_brutos', 'birthday'];
}
