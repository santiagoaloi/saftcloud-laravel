<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentDefault extends Model {
    use HasFactory;

    protected $fillable = ['config_structure'];
}
