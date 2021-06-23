<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['country_id', 'name'];
}
