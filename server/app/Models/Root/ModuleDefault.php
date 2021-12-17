<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleDefault extends Model {
    use SoftDeletes;

    protected $fillable = ['config_structure'];
}
