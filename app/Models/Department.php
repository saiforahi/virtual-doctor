<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

     public function specialityname()
     {
     return $this->belongsTo(Doctor::class, 'department_id');
     }
}
