<?php

namespace App\Http\Controllers\api;

use Auth;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

use App\Models\Features;
use App\Models\Clinic;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use App\Models\DoctorSchedule;
use App\Models\HealthData;
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
        // $new_data=HealthData::create([
        //     'patient_id'=>'',
        //     'temp'=> $request->temp,
        //     'bp_sys'=>$request->bp_sys,
        //     'bp_dia'=> $request->bp_dia,
        //     'ox'=> $request->ox,
        //     'hr'=> $request->hr
        // ]);
        return response()->json(['data'=>$request->all()]);
    }
}
