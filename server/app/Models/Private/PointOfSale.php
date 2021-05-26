<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfSale extends Model {
    use HasFactory;

    protected $fillable = ['branch_id', 'ptoVta', 'name', 'concept_id', 'look_up_list_value_id'];
}
