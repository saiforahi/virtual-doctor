<?php

namespace App\Http\Controllers\api;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Features;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use App\Models\DoctorSchedule;
use App\Models\HealthData;
use App\Models\Patient;
use App\Models\Moderator;
use App\Models\Appointment;
class IotController extends Controller
{
    public function get($appointment_id){
        $appointment = Appointment::findOrFail($appointment_id);
        if($appointment){
            return response()->json(['success'=>true,'data'=>$appointment->vital_signs]);
        }
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id'=> 'required|exists:appointments,id',
            'temp' => 'sometimes|nullable|max:255',
            'bp_sys' => 'sometimes|nullable|max:255',
            'bp_dia'=> 'sometimes|nullable|max:255',
            'ox'=> 'sometimes|nullable|max:255',
            'hr'=> 'sometimes|nullable|max:255',
            'hs'=> 'sometimes|nullable|file|max:255'
        ]);
        
        // $new_health_data = array(
        //     'temp'=> $request->temp.' F',
        //     'pulse' => $request->hr.' bpm',
        //     'bp' => $request->bp_sys.' mmHg',
        //     'ox'=> $request->ox.' %'
        // );
        $new_health_data;
        foreach($request->all() as $key => $value){
            if($key != 'appointment_id'){
                $new_health_data[$key] = $value;
            }
        }
        try{
            $appointment = Appointment::findOrFail($request->appointment_id);
            $appointment->vital_signs = json_encode($new_health_data);
            $appointment->save();
            return response()->json(['success'=>true,'message'=>'Data saved!'],200);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>'Error in saving data'],200);
        }
        // $new_data=HealthData::create([
        //     'patient_id'=>'',
        //     'temp'=> $request->temp,
        //     'bp_sys'=>$request->bp_sys,
        //     'bp_dia'=> $request->bp_dia,
        //     'ox'=> $request->ox,
        //     'hr'=> $request->hr
        // ]);
        //return response()->json(['data'=>$request->all()],200);
    }
}
