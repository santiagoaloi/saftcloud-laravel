<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model {
    use HasFactory;

    protected $fillable = ['component_group_id', 'config', 'config_settings', 'created_at', 'updated_at'];
}
