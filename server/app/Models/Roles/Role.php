<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {
   use SoftDeletes;

   protected $fillable = ['entity_id', 'name', 'description'];

   public function user(){
      return $this->belongsToMany('App\Models\User');
   }

   public function capability(){
      return $this->belongsToMany('App\Models\Roles\Capability');
   }

   public function component(){
      return $this->belongsToMany('App\Models\Root\Component');
   }
}
