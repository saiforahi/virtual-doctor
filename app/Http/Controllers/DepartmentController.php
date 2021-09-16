<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Department::latest()->get();     
        return view('admin.department',compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_department');
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
            'image'=> 'sometimes|nullable|file'
        ]);
        $image;
        if($request->has('image')){
            $image =$request->file('image');
        }
        if(isset($image)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName = $currentDate.'-'.$request->name.'.'.$image->getClientOriginalExtension();
            //check departments dir is exits
            if(!Storage::disk('public')->exists('departments')){
                Storage::disk('public')->makeDirectory('departments');
            }
            //resize image for departments and upload
            $departments = Image::make($image)->resize(64,64)->stream();
            Storage::disk('public')->put('departments/'.$imageName, $departments);
            
        }else{
            $imageName = "default.png";
        }
        $departments = new Department();
        $departments->name = $request->name;
        $departments->image = $imageName;
        $departments->save();

        Toastr::success('Department added Successfully :)','success');
        return redirect('department');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departments = Department::find($id);
        return view('admin.edit_department',compact('departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request,[
            'name' => 'required',
            //'image' => 'mimes:jpeg,bmp,jpg,png'
        ]);
        //return $request;
        // Get form images
        $image =$request->file('image');
        $slug  =str_slug($request->name);
        $departments = Department::find($id);
        if(isset($image))
        {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check category dir is exits
            if(!Storage::disk('public')->exists('departments'))
            {
                Storage::disk('public')->makeDirectory('departments');
            }
            // check old image dir
            if(Storage::disk('public')->exists('departments/'.$departments->image))
            {
                Storage::disk('public')->delete('departments/'.$departments->image);
            }
            //resize image for category and upload
            $departmentImage = Image::make($image)->resize(64,64)->stream();
            Storage::disk('public')->put('departments/'.$imageName, $departmentImage);

            
        }
        else
        {
            $imageName = $departments->image;
        }

        $departments->name = $request->name;
        $departments->image = $imageName;
        $departments->save();
        Toastr::success('Departments successfully Updated','Success');
        return redirect('department');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departments = Department::find($id);
        if(Storage::disk('public')->exists('departments/'.$departments->image))
        {
            Storage::disk('public')->delete('departments/'.$departments->image);
        }
        $departments = $departments->delete();
        Toastr::success('Departments deleted successfully','Success');
        return redirect()->back();
    }
}
