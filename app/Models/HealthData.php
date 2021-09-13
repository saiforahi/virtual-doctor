<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthData extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','moderator_id','temp','bp_sys','bp_dia','ox','hr','hs'];
    
    public function patient(){
        return $this->belongsTo(Patient::class, 'id');
    }
}
