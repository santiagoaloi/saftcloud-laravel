<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['component_group_id', 'config', 'config_settings', 'status'];
}
