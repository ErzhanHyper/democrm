<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JrnStatus extends Model
{
   protected $fillable = [
      'status',
      'project_id'
   ];
}
