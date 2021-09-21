<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\DoctorSchedule;
use Spatie\Permission\Models\Role;
use App\Models\Appointment;
use Auth;
use Mail;
use Brian2694\Toastr\Facades\Toastr;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|moderator');
    }

    /**
     * Display a listing of the resource.
     *   
     */

    public function index()
    {
        // if(Auth::user()->can('dashboard')){
        // $users = User::latest()->where('is_deleted','0')->get();
        if(Auth::user()->hasRole('admin')){
            $users = User::with('roles')
                    ->whereHas('roles', function($q) {
                        $q->where('slug', '=', 'user'); 
                    })
                    ->orderBy('created_at', 'desc')
                    ->where('is_deleted','0')->get();
        } else{
            $users = User::latest()->where('is_deleted','0')->get();
        }    
        return view('admin.user',compact('users'));
        // }else{
        //     abort(404);
        // }
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        if(Auth::user()->hasRole('admin')){
            $roles = Role::find(4);
        }else{
            $roles = Role::all();
        }

        return view('admin.create_user',compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     * 
     */
    
    public function store(Request $request)
    {
        // $timenow = Carbon::now()->diffForHumans() ;
         $timenow = Carbon::now()->toRfc2822String();
        // dd($timenow);
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users',
            'gender' => 'required',
            'age' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        set_time_limit(0);   
        ini_set('max_execution_time', 180); //3 minutes 

        // if(Auth::user()->hasRole('super-admin')){
        //     $password = $request->password;
        // }else{
        //     $password = 'Pass@123';
        // }  
        
        $password = 'Pass@123';
        

        if($request->role_id == 4){
            if(Auth::user()->hasRole('admin')){
                $html='<html>
                <h3>Dear User,</h1>
                <h3>
                Thanks for Registering with Virtual Doctor!<br>
                From now you can take advantage of our online medical services by logging into your account.
                </h3>
                <h3>Your temporary password is: Pass@123 </h3>
                <span style="color:red">please change this password after login your dashboard</span>
                <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard!</h3>
                <h3>Registration Time : '.$timenow.'</h3>
                </html>';
            }else{
               
                $html='<html>
                <h3>Dear User,</h1>
                <h3>
                Thanks for Registering with Virtual Doctor!<br>
                From now you can take advantage of our online medical services by logging into your account.
                </h3>
                <h3>Your temporary password is: Pass@123</h3>
                <span style="color:red">please change this password after login your dashboard</span>
                <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard!</h3>
                <h3>Registration Time : '.$timenow.'</h3>
                </html>'; 
            } 
             
            // dd('patient');
            $patient= User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'age' => $request->age,
                'gender' => $request->gender,
                'is_active' => 1,
                'password' =>bcrypt($password),                
            ]);
            $to = $patient->email;
            $patient->assignRole(Role::find($request->role_id));
            Mail::send([],[], function($message) use ($html,$to){
                $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                $message->to($to);
                $message->subject('Registration Successful!');
                $message->setBody($html,
                    'text/html' );              
    
            });
            $moderator = User::role('moderator')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get();

            foreach($moderator as $data){

                $mail_body='<html>
                <h3>Dear '.$data->name.',</h1>
                <h3>A new patient has been registered to VirtualDoctor!</h3>
                <h3>Name: '.$patient->name.'</h3>
                <h3>Email: '.$patient->email.'</h3>
                <h3>Phone: '.$patient->phone.'</h3>               
                <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard!</h3>
                </html>';

                $toModerator = $data->email;

                Mail::send([],[], function($message) use ($mail_body,$toModerator){
                    $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                    $message->to($toModerator);
                    $message->subject('New Patient Registration!');
                    $message->setBody($mail_body,
                        'text/html' );
                });
            }

            if(Auth::user()->hasRole('admin'))   {
                $patient_name = $patient->name;
                $patient_email = $to;
                // $patient_phone = $patient->phone;
                // $patient_pass = $password;
                
                // message 
                define( 'API_ACCESS_KEY', 'AAAAq_wHm7E:APA91bGMsE-gkkC7Iq7XGxIkPhB33zJXco3DhisWaLfhgvx3h-XjRbuvxZfJgDYsoeg3C4jd5u6uEtrdC9XGfXeMAF5PMpaci1IWho7RYR_NZaGjHf4b0wL4Hzckozc_BropyyNhDU4b' );
                
                $msg_number = $patient->phone;


                $phone_number = substr($msg_number, -11);
                $country_code = substr($msg_number, 0, -11);

                    

                //$message = 'Dear '.$patient_name.',Your account has been created successfully. Please log in at this site https://www.virtualdr.com.bd . Email:'.$patient_email.' and password is '.$patient_pass. '. Please change your password after login.' ;
                $message = 'Dear '.$patient_name.',Thanks for Registering with Virtual Doctor. 
                From now you can take advantage of our online medical services by logging into your account.
                Mail id:'.$patient_email.'; password: Pass@123. Please change this password after login';
                
                $registrationIds =  'eCGR2SJWoC8:APA91bFBfcWNmTeNWdl3BGKxNDtDV7Bt8TWDZttZAMS3liU_b1ynG-TRay4iIc9KYoP2_RhUg_UCboo2cr8Bw3Ew3Bgsa7zQYfFN20pmASwiD5cMj7hKg6BqlwE1M-jLXzuHlcuMXqHe' ;
                // prep the bundle
                $msg = array(
                    'to' => $registrationIds,
                    'data' => array(
                        'code' => $message,
                        'country' => $country_code,
                        'host_number' => $phone_number
                    )
                );

                    
                $headers = array
                (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
                );
                    
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $msg ) );
                $result = curl_exec($ch );
                // echo $result;
                // exit();
                curl_close( $ch );
                    
                // Toastr::success('Patient account created  Successfully :)','success');

            }       

        } else {

            $html='<html>
            <h3>Dear User,</h1>
            <h3>Thanks for Registering with Virtual Doctor.You will receive another email from us confirming the account registration.</h3>
            <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard!</h3>
            </html>';
            $data= User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'age' => $request->age,
                'gender' => $request->gender,
                'password' =>bcrypt($password),                
            ]);
            $to = $data->email;

            $data->roles()->attach($request->role_id);

            Mail::send([],[], function($message) use ($html,$to){
                $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                $message->to($to);
                $message->subject('Registration Successful!');
                $message->setBody($html,
                    'text/html' );    
            });
           
        }
        
        Toastr::success('Registration Completed Successfully :)','success');
        return redirect('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $user_info = User::find($id);
        $doctor_info = Doctor::where('user_id',$id)->first();
        //dd($id);
        $doctor_schedule = DoctorSchedule::where('doctor_id',$id)->get();
        $department_inf = Department::get();
        return view('admin.edit_user',compact('user_info','doctor_info','doctor_schedule','department_inf'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            // 'email' => 'required|email',
            'phone' => 'required',
        ]);

        $image = $request->file('image');
        $slug = $request->name;
        $user = User::find($id);
        // echo "<pre>";
        // // echo $id;
        // print_r($user);
        // exit();
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
                Storage::disk('public')->delete('profile/'.$user->image);
            }

            //resize image for post and upload
            $profile = Image::make($image)->resize(500,500)->stream();
            Storage::disk('public')->put('profile/'.$imageName, $profile);
            
        }else{
            $imageName = $user->image;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->blood_group = $request->blood_group;
        $user->image = $imageName;
        // $user->about = $request->about;
        $user->save();
        Toastr::success('User updated successfully.');
        return redirect()->back(); 
    }

    public function doctorPersonalInfoUpdate(Request $request)
    {
        $id = $request->doctor_id;
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
        $id = $request->doctor_id;
        $doctor_info = Doctor::where('user_id',$id)->first();

        $departments = $request->input('department');
        $degrees = $request->input('degree');
        $institutes = $request->input('institute');
        $total_row = count($departments);
        for($i=0;$i < $total_row; $i++) { $department=$departments[$i]; $degree=$degrees[$i]; $institute=$institutes[$i];
            $completedegree[]=$department.','.$degree.','.$institute; } $string_all_value=implode("|",$completedegree);
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
    public function deleteSchedule($doctor_id,$scdid)
    {
        DoctorSchedule::where('id', $scdid)->delete();
    }
    
    public function approve_user($id)
    { 
        set_time_limit(0);   
        ini_set('max_execution_time', 180); //3 minutes      
        $user = User::find($id);     
        $html='<html>
        <h3>Dear '.$user->name.',</h1>
        <h3>Your account has been approved successfully for virtualdr.com.bd!</h1>
        <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard!</h3>
        </html>';  
        $to = $user->email;

        $user->where('id', $id)->update(array('is_active' => 1));
        // send mail              
        Mail::send([],[], function($message) use ($html,$to){
            $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
            $message->to($to);
            $message->subject('Account Activated!');
            $message->setBody($html,
                'text/html' );
        });
        // send mail
        Toastr::success('User Approved successfully.');
        return redirect()->back(); 
    }
    
    public function pending_user($id)
    {
        $user = User::find($id);
        $user->where('id', $id)->update(array('is_active' => 0));
        Toastr::success('User Pending successfully.');
        return redirect()->back(); 
    }

    public function destroy($id)
    {
        // dd('deleted');
        $user = User::find($id);
        $user->where('id', $id)->update(array('is_deleted' => 1));
        Toastr::success('User Deleted successfully.');
        return redirect()->back(); 
    }


    
}
