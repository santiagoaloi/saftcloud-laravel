<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSettings extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'view_config'];
}
