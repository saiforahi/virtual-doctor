<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
class Device extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable=['name'];
    protected $with=[];
    public function appointment(){
        return $this->belongsTo(Appointment::class,'id','device_id');
    }
}
