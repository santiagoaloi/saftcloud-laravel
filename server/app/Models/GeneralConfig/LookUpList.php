<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LookUpList extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];
}
