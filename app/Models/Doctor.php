<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
   protected $fillable = ['user_id','department_id','moderator_id','registration_no','licence_no','ptr_no','s2_no','educational_degrees','visit_fee','isActiveForScheduling'];
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
