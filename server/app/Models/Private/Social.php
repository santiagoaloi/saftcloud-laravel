<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Social extends Model {
    use SoftDeletes;

    protected $fillable = ['description', 'url'];

    public function socialable(){
        return $this->MorphTo();
    }
}
