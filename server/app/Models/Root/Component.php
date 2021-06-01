<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model {
    use HasFactory;

    protected $fillable = ['component_group_id', 'prev_group_id', 'component_id', 'name', 'title', 'note', 'config', 'config_settings'];
}
