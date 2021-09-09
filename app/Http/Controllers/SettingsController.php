<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Doctor;
use App\Department;
use App\DoctorSchedule;
use App\Day;
use Hash;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $doctor_info = '';
        $doctor_schedule = '';
        $department_inf = Department::get();
        if(Auth::user()->hasRole('power-user'))
        {
            $id = Auth::user()->id;
            $doctor_info = Doctor::where('user_id',$id)->first();
            $doctor_schedule = DoctorSchedule::where('doctor_id',$id)->get();
        }
    	return view('admin.settings', compact('doctor_info','doctor_schedule','department_inf'));
    }
    public function updateProfile(Request $request)
    {
    	//return $request;
    	$this->validate($request,[
    		'name' => 'required',
    		// 'email' => 'required|email',
    	]);

        $is_image = $request->is_image;

        $user = User::findOrFail(Auth::id());
        
        if($is_image === 'on')
        {
        	$image = $request->file('image');
        	$slug = $request->name;

        	if(isset($image)){
                //make unique name for image
                $currentDate = Carbon::now()->toDateString();
                $imageName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                //check post dir is exits
                if(!Storage::disk('public')->exists('profile')){
                    Storage::disk('public')->makeDirectory('profile');
                }

                // delete old image dir
                if(Storage::disk('public')->exists('profile/'.$user->image))
                {
                    if($user->image != 'no_profile.png')
                    {
                        Storage::disk('public')->delete('profile/'.$user->image);
                    }
                }

                //resize image for post and upload
                $profile = Image::make($image)->resize(500,500)->stream();
                Storage::disk('public')->put('profile/'.$imageName, $profile);
                
            }else{
                $imageName = $user->image;
            }
        }
        else
        {
            $imageName = 'no_profile.png';
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->blood_group = $request->blood_group;
        $user->image = $imageName;
        // $user->about = $request->about;
        $user->save();
        Toastr::success('Profile updated successfully.');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        //return $request;
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->old_password,$hashedPassword))
        {
            if(!Hash::check($request->password,$hashedPassword))
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password Successfulluy changed','Success');
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('New password cannot be the same as old password','Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match','Error');
            return redirect()->back();
        }

    }

    public function doctorPersonalInfoUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $doctor_info = Doctor::where('user_id',$id)->first();
        $doctor_info->registration_no = $request->registration_no;
        $doctor_info->licence_no = $request->licence_no;
        $doctor_info->ptr_no = $request->ptr_no;
        $doctor_info->s2_no = $request->s2_no;
        $doctor_info->visit_fee = $request->visit_fee;
        $doctor_info->save();
        Toastr::success('Professional information updated successfully.');
        return redirect()->back();
    }
    public function updateDegree(Request $request)
    {
        $id = Auth::user()->id;
        $doctor_info = Doctor::where('user_id',$id)->first();

        $departments = $request->input('department');
        $degrees = $request->input('degree');
        $institutes = $request->input('institute');
        $total_row = count($departments);
        for($i=0;$i < $total_row; $i++)
        {
            $department = $departments[$i];
            $degree = $degrees[$i];
            $institute = $institutes[$i];
            $completedegree[] = $department.','.$degree.','.$institute;
        }
        $string_all_value = implode("|",$completedegree);
        
        Doctor::where('id', $doctor_info->id)->update(array('educational_degrees' => $string_all_value));

        Toastr::success('Degree updated successfully.');
        return redirect()->back();
    }


    public function doctorSchedule(Request $request)
    {
        $id = $request->input('doc_id');


        $sche_info = DoctorSchedule::where('doctor_id',$id)->get();
        

        $start_times = $request->input('start_time');
        $end_times = $request->input('end_time');
        $days = $request->input('day_name');
        $schedule_id = $request->input('schedule_id');
        $total_row = count($start_times);

        for($i=0;$i < $total_row; $i++)
        {
            $start_time = $start_times[$i];
            $end_time = $end_times[$i];
            $day_name = $days[$i];

            if(count($start_times) > 0)
            {
                $scd_id = $schedule_id[$i];
            }
            else
            {
                $scd_id = '';
            }
            


            if($scd_id)
            {
                DoctorSchedule::where('id', $scd_id)->update(array('doctor_id' => $id,'day_name' => $day_name,'start_time' => $start_time,'end_time' => $end_time));
               

            }
            else{
                $scheduleInfo = new DoctorSchedule;
                $scheduleInfo->doctor_id = $id;
                $scheduleInfo->day_name = $day_name;
                $scheduleInfo->start_time = $start_time;
                $scheduleInfo->end_time = $end_time;
                
                $scheduleInfo->save();
            }
        }
        Toastr::success('Time Schedule updated successfully.');
        return redirect()->back();
    }

    public function deleteSchedule($scdid)
    {
        DoctorSchedule::where('id', $scdid)->delete();
    }
}