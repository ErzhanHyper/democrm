<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
   public $timestamps = false;

   protected $fillable = [
      'name', 'description', 'dtin', 'owner', 'collaborators', 'client_id', 'tasks', 'status',
   ];

   public function client(){
      return $this->belongsTo('App\Client', 'client_id');
   }

   public function user(){
      return $this->belongsTo('App\User', 'owner');
   }

   public function task(){
      return $this->hasMany('App\Task', 'project_id');
   }

   public function statuses(){
      return $this->belongsTo('App\Status', 'status');
   }

}
