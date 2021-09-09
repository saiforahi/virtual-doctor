<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];
    public function users()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
    public function doctors()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function slots()
    {
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id');
    }
}
