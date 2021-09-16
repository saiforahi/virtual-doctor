<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

use App\Models\Features;
use App\Models\Clinic;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use App\Models\DoctorSchedule;

class HomeController extends Controller
{

    public function index()
    {

        // $clinic = Clinic::all();
        $features = Features::latest()->get();
        $departments = Department::latest()->get();
        $doctor = Doctor::with('users')->whereHas('users', function ($q) {$q->where('is_active','1')->where('is_deleted', '=', '0');})->where('department_id','!=',null)->get();
        //dd($doctor);
        return view('welcome', compact('doctor', 'features', 'departments'));
    }


    public function searchDoctor(Request $request)
    {
        //kdd($request->all());
        $departments = Department::latest()->get();
        // Search Doctor        
        $keyword = $request->input('kw');
        $location = $request->input('location');
        $speciality = $request->input('specialist');
        $gender = $request->input('gender');
        // dd($gender);
        $counter = 0;
        if ($keyword != "" && $location == "") {
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->orWhere("users.name", "LIKE", "%$keyword%")
                ->orWhere("departments.name", "LIKE", "%$keyword%")
                // ->where("address", "LIKE", "%$location%")
                ->where('is_deleted', '=', 0)
                ->where('is_active', '=', 1)
                ->paginate(5);
        } elseif ($keyword == "" && $location != "" && empty($gender) && empty($speciality)) {
            // dd('2nd');
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->where("address", "LIKE", "%$location%")
                ->where('is_deleted', '=', 0)
                ->where('is_active', '=', 1)
                ->paginate(5);
        } elseif (!empty($gender) && !empty($speciality) && $location != "" && $keyword == "") {
            //dd("3rd");
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->WhereIn("departments.name", $speciality)
                ->WhereIn("users.gender", $gender)
                ->Where("users.address", "LIKE", "%$location%")
                ->where('users.is_deleted', '=', 0)
                ->where('users.is_active', '=', 1)
                ->paginate(5);
        } elseif (empty($gender) && !empty($speciality) && $location != "" && $keyword == "") {
            //dd("4th");
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->WhereIn("departments.name", $speciality)
                ->Where("users.address", "LIKE", "%$location%")
                ->where('users.is_deleted', '=', 0)
                ->where('users.is_active', '=', 1)
                ->paginate(5);
        } elseif (!empty($gender) && !empty($speciality) && $location == "" && $keyword == "") {
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->WhereIn("departments.name", $speciality)
                ->WhereIn("users.gender", $gender)
                //->where("users.address", "LIKE", "%$location%")
                ->where('users.is_deleted', '=', 0)
                ->where('users.is_active', '=', 1)
                ->paginate(5);
        } elseif (!empty($gender) && empty($speciality) && $location != "" && $keyword == "") {
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->WhereIn("users.gender", $gender)
                ->where("users.address", "LIKE", "%$location%")
                ->where('users.is_deleted', '=', 0)
                ->where('users.is_active', '=', 1)
                ->paginate(5);
        } elseif (!empty($gender) && empty($speciality) && $location == "" && $keyword == "") {
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->WhereIn("users.gender", $gender)
                // ->where("users.address", "LIKE", "%$location%")
                ->where('users.is_deleted', '=', 0)
                ->where('users.is_active', '=', 1)
                ->paginate(5);
        } elseif (empty($gender) && !empty($speciality) && $location == "" && $keyword == "") {
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->WhereIn("departments.name", $speciality)
                ->where('users.is_deleted', '=', 0)
                ->where('users.is_active', '=', 1)
                ->paginate(5);
        } else {
            $doctor = Doctor::join('departments', 'doctors.department_id', '=', 'departments.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->orWhere("departments.name", "LIKE", "%$keyword%")
                ->orWhere("users.name", "LIKE", "%$keyword%")
                ->where("address", "LIKE", "%$location%")
                ->where('is_deleted', '=', 0)
                ->where('is_active', '=', 1)
                ->paginate(5);
        }

        $counter = $doctor->count();

        return view('layouts.portal.pages.search_doctor', compact(
            'doctor',
            'speciality',
            'gender',
            'location',
            'keyword',
            'departments',
            'counter'
        ));
    }


    public function doctorProfile($id)
    {
        $doctor = User::findOrFail($id);
        $drSchedule = DoctorSchedule::where('doctor_id', $id)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_name');

        // dd($drSchedule);

        return view('layouts.portal.pages.doctor_profile', compact('id', 'doctor', 'drSchedule'));
    }

    public function bookAppoinment($id)
    {
        $doctor = User::findOrFail($id);
        return view('layouts.portal.pages.book_appointment', compact('id', 'doctor'));
    }

    public function checkout($id, $schedule_id)
    {
        $doctor = Doctor::with('users')->where('user_id',$id)->first();
        //dd($doctor);
        $schedule = DoctorSchedule::findOrFail($schedule_id);
        return view('layouts.portal.pages.checkout', compact('id', 'schedule_id', 'doctor', 'schedule'));
    }

    public function patientLogin()
    {
        return view('auth.patient_login');
    }

    public function bookingSuccess()
    {
        return view('layouts.portal.pages.booking-success');
    }
}
