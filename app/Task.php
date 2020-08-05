<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   public $timestamps = false;
   protected $fillable = [
      'name', 'dtin', 'dtout', 'executor', 'status', 'image', 'project_id'
   ];


   public function user(){
      return $this->belongsTo('App\User', 'executor');
   }

   public function project(){
      return $this->belongsTo('App\Project', 'project_id');
   }

}
