<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Doctor;
class EnsureProfileIsUpdated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //$response = ;
        if(Auth::user()->hasRole('doctor')){
            $doctor = Doctor::where('user_id',Auth::user()->id)->first();
            if($doctor->department_id == null || $doctor->educational_degrees == null || $doctor->registration_no == null){
                return redirect()->route('settings');
            }
            else{
                return $next($request);
            }
        }
        return $next($request);
    }
}
