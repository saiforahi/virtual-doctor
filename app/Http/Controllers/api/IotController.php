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
class IotController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'temp' => 'sometimes|nullable|max:255',
            'bp_sys' => 'sometimes|nullable|max:255',
            'bp_dia'=> 'sometimes|nullable|max:255',
            'ox'=> 'sometimes|nullable|max:255',
            'hr'=> 'sometimes|nullable|max:255',
            'hs'=> 'sometimes|nullable|file|max:255'
        ]);
        if($request->hs != NULL){
            $path = $request->file('hs')->store('heart_sounds');
        }
        $new_health_data = HealthData::create([
            'patient_id'=> Patient::all()[0]->id,
            'moderator_id'=> Moderator::all()[0]->id,
            'temp'=> $request->temp,
            'bp_sys'=> $request->bp_sys,
            'bp_dia'=> $request->bp_dia,
            'ox'=> $request->ox,
            'hr'=> $request->hr,
            //'hs'=> $request-> $path
        ]);
        // $new_data=HealthData::create([
        //     'patient_id'=>'',
        //     'temp'=> $request->temp,
        //     'bp_sys'=>$request->bp_sys,
        //     'bp_dia'=> $request->bp_dia,
        //     'ox'=> $request->ox,
        //     'hr'=> $request->hr
        // ]);
        return response()->json(['data'=>$request->all()],200);
    }
}
