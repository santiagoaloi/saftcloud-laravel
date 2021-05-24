<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model {
    use HasFactory;

    protected $fillable = ['group_id', 'prev_group_id', 'parent_id', 'controller', 'title', 'note', 'type_id', 'icon', 'global', 'protected'];
}
