<?php

namespace App\Models\Root;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentGroup extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['component_group_id', 'name', 'icon', 'ordering'];
}
