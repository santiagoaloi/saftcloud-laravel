<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfSale extends Model {
    use HasFactory;

    protected $connection = 'mysql';
    protected $fillable = ['branch_id', 'ptoVta', 'name', 'address'];
}
