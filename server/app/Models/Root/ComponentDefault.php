<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentDefault extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['config_structure'];
}
