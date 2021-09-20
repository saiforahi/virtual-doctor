<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use Validator;
use App\Models\Appointment;
use Brian2694\Toastr\Facades\Toastr;
class DeviceController extends Controller
{
    //
    public function index()
    {
        $devices = Device::latest()->get();     
        return view('admin.devices',compact('devices'));
    }
    public function create()
    {
        return view('admin.create_device');
    }

    public function store(Request $req){
        $validate = Validator::make($req->all(),[
            'device_id'=> 'sometimes|nullable|unique:devices',
            'name'=> 'required|string|max:255',
        ]);
        if($validate->fails()){
            return redirect()->to('device.create')->withErrors($validate->errors())->withInput($request->all());
        }
        $new_device = new Device();
        foreach ($req->all() as $key => $value) {
            if($key != '_token'){
                $new_device[$key] = $value;
            }
        }
        $new_device->save();
        if($new_device){
            Toastr::success('Device successfully Added','Success');
            return redirect()->to('device');
        }
    }

    public function destroy($id){
        $deleted_device = Device::findOrFail($id)->delete();
        if($deleted_device){
            Toastr::success('Device successfully deleted','Success');
            return redirect()->to('device');
        }
    }

    public function edit($id)
    {
        $device = Device::find($id);
        return view('admin.edit_device',compact('device'));
    }

    public function update(Request $req,$id){
        $validate = Validator::make($req->all(),[
            'id'=> 'required|string|exists:devices',
            'name'=> 'required|string|max:255'
        ]);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors())->withInput($req->all());
        }
        $device = Device::findOrFail($id);
        foreach($req->all() as $key=>$value){
            if($key != '_token' && $key!= '_method'){
                $device[$key]=$value;
            }
        }
        $device->save();
        if($device){
            return redirect()->to('device');
        }
    }

    public function allocated_appointment($id){
        $appointment = Appointment::where('device_id',$id)->first();
        if($appointment){
            return response()->json(['success'=>true,'appointment_id'=>$appointment->id]);
        }
        return response()->json(['success'=>false,'message'=>'This device is not allocated yet!']);
    }
}
