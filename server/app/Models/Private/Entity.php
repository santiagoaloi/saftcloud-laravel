<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['account_id', 'entity_type_id', 'first_name', 'last_name', 'iva_condition', 'doc_type_id', 
    'doc_num', 'ing_brutos', 'birthday'];
}
