<?php

namespace App\Models\Private;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSetting extends Model {
    use SoftDeletes;

    protected $fillable = ['user_id', 'view_config', 'default_branch'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
