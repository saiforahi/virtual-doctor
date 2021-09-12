<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Auth;
use App\Models\File;



class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard(){

    }
    public function index()
    {        
        $approval_users = '';
        $moderators = '';
        $doctors = '';
        $patients = '';
        $appoinments = '';
        $patient_history = '';
        $followup_patient_list = '';
        $my_history = '';
        $my_patients = '';
        $dashboard_info = '';
        $total_moderators = 0;
        $total_doctors = 0;
        $total_approval = 0;
        $my_file = 0;
        //dd(User::role('doctor')->where('id',Auth::user()->id)->exists());
        if (Auth::user()->hasRole(Role::where('name','moderator')->first()->id) || Auth::user()->hasRole(Role::where('name','admin')->first()->id)){
            //dd('found');
            $approval_users = User::latest()->where('is_active', 0)->where('is_deleted', 0)->get();
            $total_approval = $approval_users->count();
            $moderators = User::role('moderator')->where('is_active', 1)->where('is_deleted', 0)->orderBy('created_at', 'desc')->get();
            $total_moderators = $moderators->count();
            $doctors = User::role('doctor')->where('is_active', 1)->where('is_deleted', 0)->orderBy('created_at', 'desc')->get();
            $total_doctors = $doctors->count();
            $appoinments = Appointment::where('isbooked', 1)->where('isServiced', 0)->orderBy('created_at', 'asc')->get();
            // total patients
            $patient_history = Appointment::latest()->where('isbooked', 1)->where('isServiced', 1)->get()->unique('patient_id');
            $patients = User::role('patient')->where('is_active', 1)->where('is_deleted', 0)->get();
            $total_patient = $patients->count();
            // dd($total_patient);
            // followup patients
            $followup = Appointment::latest()->where('isbooked', 1)->where('isServiced', 1)->whereNotNull('follow_up_visit_date')->get()->groupBy('patient_id');

            $followup_patient = $followup->count();

            $followup_patient_list = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->whereNotNull('follow_up_visit_date')
                ->where('isScheduled', 0)
                ->get()->unique('patient_id');


            // new patients

            $new_patient = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 0)
                ->get();
            $new_patient = $new_patient->count();

            $dashboard_info = array('total_patient' => $total_patient, 'followup_patient' => $followup_patient, 'new_patient' => $new_patient);
        }

        if (Auth::user()->hasRole(Role::where('name','doctor')->first()->id)) {
            $appoinments = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 0)
                ->where('doctor_id', Auth::user()->id)
                ->get();

            $patients = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->where('doctor_id', Auth::user()->id)
                ->get()->groupBy('patient_id');

            $my_patients = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->where('doctor_id', Auth::user()->id)
                ->get()->unique('patient_id');
            // dd($my_patients);
            $total_patient = $patients->count();

            $followup_patient_list = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->where('doctor_id', Auth::user()->id)
                ->whereNotNull('follow_up_visit_date')
                ->get();


            // followup patients

            $followup = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->where('doctor_id', Auth::user()->id)
                ->whereNotNull('follow_up_visit_date')
                ->get()->groupBy('patient_id');
            $followup_patient = $followup->count();

            // new patients

            $new_patient = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 0)
                ->where('doctor_id', Auth::user()->id)
                ->get();

            $new_patient = $new_patient->count();

            $dashboard_info = array('total_patient' => $total_patient, 'followup_patient' => $followup_patient, 'new_patient' => $new_patient);
        }

        if (Auth::user()->hasRole(Role::where('name','patient')->first()->id)) {
            $appoinments = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 0)
                ->where('patient_id', Auth::user()->id)
                ->get();
            $my_history = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->where('patient_id', Auth::user()->id)
                ->get();

            $my_file = File::latest()
                ->where('user_id', Auth::user()->id)
                ->get();

            $total_patient = 0;

            // followup patients
            $followup_patient = 0;

            // new patients
            $new_patient = 0;

            $dashboard_info = array('total_patient' => $total_patient, 'followup_patient' => $followup_patient, 'new_patient' => $new_patient);
        }
        // dd($appoinments);
        $users = User::role('patient')->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact(
            'approval_users',
            'followup_patient_list',
            'moderators',
            'total_moderators',
            'doctors',
            'patients',
            'total_doctors',
            'users',
            'appoinments',
            'my_history',
            'my_patients',
            'dashboard_info',
            'total_approval',
            'patient_history',
            'my_file'
        ));
    }
}
