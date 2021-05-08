<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtoVta extends Model {
    use HasFactory;

    protected $connection = 'system';
    protected $fillable = ['branch_id', 'ptoVta', 'name', 'address'];
}
