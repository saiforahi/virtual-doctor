<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinic = Clinic::latest()->get();     
        return view('admin.clinic',compact('clinic'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_clinic');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            // 'image' => 'required',

        ]);

        $image =$request->file('image');
        $slug  =str_slug($request->name);
        if(isset($image)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check clinics dir is exits
            if(!Storage::disk('public')->exists('clinic')){
                Storage::disk('public')->makeDirectory('clinic');
            }
            //resize image for clinics and upload
            $clinics = Image::make($image)->resize(201,52)->stream();
            Storage::disk('public')->put('clinic/'.$imageName, $clinics);
            
        }else{
            $imageName = "default.png";
        }

        if(isset($favicon)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $faviconName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$favicon->getClientOriginalExtension();
            //check features dir is exits
            if(!Storage::disk('public')->exists('clinic')){
                Storage::disk('public')->makeDirectory('clinic/favicon');
            }
            //resize image for clinics and upload
            $clinics = Image::make($image)->resize(201,52)->stream();
            Storage::disk('public')->put('clinic/favicon/'.$faviconName, $clinics);
            
        }else{
            $faviconName = "default.png";
        }
        $clinics = new Clinic();
        $clinics->name = $request->name;
        $clinics->phone = $request->phone;
        $clinics->email = $request->email;
        $clinics->address = $request->address;
        $clinics->image = $imageName;
        $clinics->favicon = $faviconName;
        $clinics->save();
        //dd($clinics);

        

        Toastr::success('Clinics Inserted Successfully :)','success');
        return redirect('clinic');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function show(Clinic $clinic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clinic = Clinic::find($id);
        return view('admin.edit_clinic',compact('clinic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $image =$request->file('image');
        $slug  =str_slug($request->name);
        $clinics = Clinic::find($id);
        if(isset($image)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check features dir is exits
            if(!Storage::disk('public')->exists('clinic')){
                Storage::disk('public')->makeDirectory('clinic');
            }

            // delete old image dir
            if(Storage::disk('public')->exists('clinic/'.$clinics->image))
            {
                Storage::disk('public')->delete('clinic/'.$clinics->image);
            }

            //resize image for post and upload
            $clinicImage = Image::make($image)->resize(600,600)->stream();
            Storage::disk('public')->put('clinic/'.$imageName, $clinicImage);
            
        }else{
            $imageName = $clinics->image;
        }

        if(isset($favicon)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $faviconName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$favicon->getClientOriginalExtension();
            //check features dir is exits
            if(!Storage::disk('public')->exists('clinic')){
                Storage::disk('public')->makeDirectory('clinic/favicon');
            }

            // delete old image dir
            if(Storage::disk('public')->exists('clinic/favicon/'.$clinics->favicon))
            {
                Storage::disk('public')->delete('clinic/favicon/'.$clinics->favicon);
            }

            //resize image for post and upload
            $favImage = Image::make($favicon)->resize(600,600)->stream();
            Storage::disk('public')->put('clinic/favicon/'.$faviconName, $favImage);
            
        }else{
            $faviconName = $clinics->favicon;
        }

        $clinics->name = $request->name;
        $clinics->phone = $request->phone;
        $clinics->email = $request->email;
        $clinics->address = $request->address;
        $clinics->image = $imageName;
        $clinics->favicon = $faviconName;
        
        $clinics->save();
        //dd($features);
        Toastr::success('Clinics successfully Updated','Success');
        return redirect('clinic');
        //return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clinic::destroy($id);
        Toastr::success('Clinic Deleted successfully.');
        return redirect()->back(); 
    }
}
