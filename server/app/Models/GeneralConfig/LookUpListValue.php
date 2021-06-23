<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LookUpListValue extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['look_up_list_id', 'name', 'value'];
}
