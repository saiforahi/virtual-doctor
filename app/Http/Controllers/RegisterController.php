<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\App\Modelsointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Brian2694\Toastr\Facades\Toastr;
use Mail;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
    }

    public function new_patient_register()
    {
        return view('auth.new_patient',['patient_role_id'=>Role::where('name','patient')->first()->id]);
    }

    public function new_doctor_or_moderator_register()
    {
        return view('auth.register');
    }

    public function new_patient_store(Request $request)
    {
        // dd('new patient');
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users',
            'gender' => 'required',
            'age' => 'required',
            // 'email' => 'string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $moderators = User::role('admin')->get();
        set_time_limit(0);
        ini_set('max_execution_time', 180); //3 minutes 

        // dd($request->all());

        $html = '<html>
        <h3>Dear User,</h1>
        <h3>
        Thanks for Registering with VirtualDoctor!<br>
        You can take the advantage of our online medical services by logging into your account.<br>
        Thank you
        </h3>';

        // dd('patient');
        $patient = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'email' => $request->email,
            'is_active' => 1,
            'age' => $request->age,
            'address' => $request->address,
            'password' => bcrypt($request->password),
        ]);

        $to = $patient->email;
        $patient->roles()->attach(4);


        //  send sms to patient
        $patient_name = $patient->name;
        $patient_email = $to;
        // message 
        define('API_ACCESS_KEY', 'AAAAq_wHm7E:APA91bGMsE-gkkC7Iq7XGxIkPhB33zJXco3DhisWaLfhgvx3h-XjRbuvxZfJgDYsoeg3C4jd5u6uEtrdC9XGfXeMAF5PMpaci1IWho7RYR_NZaGjHf4b0wL4Hzckozc_BropyyNhDU4b');

        $msg_number = $patient->phone;

        $phone_number = substr($msg_number, -11);
        $country_code = substr($msg_number, 0, -11);

        //$message = 'Dear '.$patient_name.',Your account has been created successfully. Please log in at this site https://www.virtualdr.com.bd . Email:'.$patient_email.' and password is '.$patient_pass. '. Please change your password after login.' ;
        $message = 'Dear ' . $patient_name . ',Thanks for Registering with Virtual Doctor.From now you can take advantage of our online medical services by logging into your account.
        Mail id:' . $patient_email . '; Password: Pass@123; Please change this password after login';

        $registrationIds =  'eCGR2SJWoC8:APA91bFBfcWNmTeNWdl3BGKxNDtDV7Bt8TWDZttZAMS3liU_b1ynG-TRay4iIc9KYoP2_RhUg_UCboo2cr8Bw3Ew3Bgsa7zQYfFN20pmASwiD5cMj7hKg6BqlwE1M-jLXzuHlcuMXqHe';
        // prep the bundle
        $msg = array(
            'to' => $registrationIds,
            'data' => array(
                'code' => $message,
                'country' => $country_code,
                'host_number' => $phone_number
            )
        );

        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
        $result = curl_exec($ch);
        // echo $result;
        // exit();
        curl_close($ch);

        // send mail to patient for account creation
        if ($to != '') {
            Mail::send([], [], function ($message) use ($html, $to) {
                $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                $message->to($to);
                $message->subject('Registration Successful!');
                $message->setBody(
                    $html,
                    'text/html'
                );
            });
        }


        // send mail to moderator for new patient creation
        foreach ($moderators as $data) {

            $mail_body = '<html>
            <h3>Dear ' . $data->name . ',</h1>
            <h3>A new patient has been registered to VirtualDoctor!</h3>
            <h3>Name: ' . $patient->name . '</h3>
            <h3>Email: ' . str_replace(' ','',$patient->email) . '</h3>
            <h3>Phone: ' . $patient->phone . '</h3>               
            <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard!</h3>
            </html>';

            $toModerator = $data->email;

            if($toModerator!=""){
                Mail::send([], [], function ($message) use ($mail_body, $toModerator) {
                    $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                    $message->to($toModerator);
                    $message->subject('New Patient Registration!');
                    $message->setBody(
                        $mail_body,
                        'text/html'
                    );
                });
            }
            
        }

        // create appointment
        $uniqid = Str::random(9);
        $vital_signs = 'Temperature:  F,Pulse:  bpm, Blood Pressure: mmHg, Oxygen Rate:  %,Weight: ';

        $data = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'room_id' => $uniqid,
            'patient_type' => 'New',
            'vital_signs' => $vital_signs,
            'visit_date' => date("Y-m-d", strtotime($request->visit_date)),
            'schedule_id' => $request->schedule_id,
            'isbooked' => 1,
            'isApproved' => 0,
        ]);
        // End create appointment 

        // Toastr::success('Request Completed Successfully :)', 'success');
        
        Auth::loginUsingId($patient->id, TRUE);
        return redirect('booking-success');
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users',
            'gender' => 'required',
            'age' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required','string','min:8','confirmed',Password::min(8)->numbers()->letters()],
        ]);

        $moderators = User::role('moderator')->get();
        set_time_limit(0);
        ini_set('max_execution_time', 180); //3 minutes 

        // dd($request->all());
        if (Role::find($request->role_id)->name == 'patient') {
            $html = '<html>
            <h3>Dear User,</h1>
            <h3>
            Thanks for Registering with Virtual Doctor!<br>From now you can take advantage of our online medical services by logging into your account.
            </h3>
            <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard!</h3>
            </html>';

            // dd('patient');
            $patient = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'age' => $request->age,
                'gender' => $request->gender,
                'is_active' => 1,
                'password' => bcrypt($request->password),
            ]);

            $to = $patient->email;
            $patient->roles()->attach($request->role_id);

            Patient::create([
                'user_id' => $patient->id,
            ]);

            // send mail to patient for account creation
            if ($to != "") {
                Mail::send([], [], function ($message) use ($html, $to) {
                    $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                    $message->to($to);
                    $message->subject('Registration Successful!');
                    $message->setBody(
                        $html,
                        'text/html'
                    );
                });
            }

            // send mail to moderator for new patient creation
            foreach ($moderators as $data) {

                $mail_body = '<html>
                <h3>Dear ' . $data->name . ',</h1>
                <h3>A new patient has been registered to VirtualDoctor!</h3>
                <h3>Name: ' . $patient->name . '</h3>
                <h3>Email: ' . $patient->email . '</h3>
                <h3>Phone: ' . $patient->phone . '</h3>               
                <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard!</h3>
                </html>';

                $toModerator = $data->email;

                Mail::send([], [], function ($message) use ($mail_body, $toModerator) {
                    $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                    $message->to($toModerator);
                    $message->subject('New Patient Registration!');
                    $message->setBody(
                        $mail_body,
                        'text/html'
                    );
                });
            }
            // Auth::loginUsingId($patient->id, TRUE);
            Toastr::success('Registration Completed Successfully :)', 'success');
            return redirect('patient-login');
        } elseif (Role::find($request->role_id)->name == 'doctor') {
            $html = '<html>
            <h3>Dear User,</h1>
            <h3>Thanks for Registering with Virtual Doctor.You will receive another email from us confirming the account registration.</h3>
            <h3>Thank you.</h3>
            </html>';

            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'age' => $request->age,
                'gender' => $request->gender,
                'password' => bcrypt($request->password),
            ]);

            $to = $data->email;
            $data->roles()->attach($request->role_id);
            Doctor::create([
                'user_id' => $data->id,
            ]);

            Mail::send([], [], function ($message) use ($html, $to) {
                $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                $message->to($to);
                $message->subject('Registration Successful!');
                $message->setBody(
                    $html,
                    'text/html'
                );
            });
        } else {
            $html = '<html>
            <h3>Dear User,</h1>
            <h3>Thanks for Registering with Virtual Doctor.You will receive another email from us confirming the account registration.</h3>
            <h3>Thank you.</h3>
            </html>';
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'age' => $request->age,
                'gender' => $request->gender,
                'password' => bcrypt($request->password),
            ]);
            $to = $data->email;
            $data->roles()->attach($request->role_id);
            Mail::send([], [], function ($message) use ($html, $to) {
                $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                $message->to($to);
                $message->subject('Registration Successful!');
                $message->setBody(
                    $html,
                    'text/html'
                );
            });
        }
        // dd($data);
        Toastr::success('Registration Completed Successfully :)', 'success');
        return redirect('/login');
    }
}
