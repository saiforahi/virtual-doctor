<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = [];

     public function users()
     {
        return $this->belongsTo(User::class, 'user_id');
     }

     public function speciality()
     {
        return $this->hasMany(Department::class, 'department_id');
     }
}
