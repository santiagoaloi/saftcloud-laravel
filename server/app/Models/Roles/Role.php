<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {
   use SoftDeletes;

   protected $fillable = ['entity_id', 'name'];

   public function users(){
      return $this->belongsToMany('App\Models\User');
   }

   public function capabilities(){
      return $this->belongsToMany('App\Models\Roles\Capability');
   }
}
