<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonType extends Model {
    use HasFactory;

    protected $fillable = ['name', 'descrtiption'];
}
