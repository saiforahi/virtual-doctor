<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Features;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Features::latest()->get();     
        return view('admin.features',compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_features');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data= Features::create([
        //     'name' => $request->name,
        //     'title' => $request->title,
        //     'description' => $request->description
            
        // ]);
        // //dd($data);

        // Toastr::success('Features Inserted Successfully :)','success');
        // return redirect('features');



        $this->validate($request,[
            'name' => 'required',
            'title' => 'required',
            //'description' => 'required',
            //'image' => 'required',

        ]);

        $image =$request->file('image');
        $slug  =str_slug($request->title);
        if(isset($image)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check features dir is exits
            if(!Storage::disk('public')->exists('features')){
                Storage::disk('public')->makeDirectory('features');
            }
            //resize image for features and upload
            $features = Image::make($image)->resize(600,600)->stream();
            Storage::disk('public')->put('features/'.$imageName, $features);
            
        }else{
            $imageName = "default.png";
        }
        $features = new Features();
        $features->name = $request->name;
        $features->title = $request->title;
        $features->description = $request->description;
        $features->image = $imageName;
        $features->save();
        //dd($features);

        

        Toastr::success('Features Inserted Successfully :)','success');
        return redirect('features');
        //return $request;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $features = Features::find($id);
        return view('admin.edit_features',compact('features'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $this->validate($request,[
            'name' => 'required',
            'title' => 'required',
            // 'description' => 'required',
            // 'image' => 'required',

        ]);

        $image =$request->file('image');
        $slug  =str_slug($request->title);
        $features = Features::find($id);
        if(isset($image)){
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check features dir is exits
            if(!Storage::disk('public')->exists('features')){
                Storage::disk('public')->makeDirectory('features');
            }

            // delete old image dir
            if(Storage::disk('public')->exists('features/'.$features->image))
            {
                Storage::disk('public')->delete('features/'.$features->image);
            }

            //resize image for post and upload
            $featuresImage = Image::make($image)->resize(600,600)->stream();
            Storage::disk('public')->put('features/'.$imageName, $featuresImage);
            
        }else{
            $imageName = $features->image;
        }

        $features->name = $request->name;
        $features->title = $request->title;
        $features->description = $request->description;
        $features->image = $imageName;
        
        $features->save();
        //dd($features);
        Toastr::success('Features successfully Updated','Success');
        return redirect('features');
        //return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $features = Features::find($id);
        if(Storage::disk('public')->exists('features/'.$features->image))
        {
            Storage::disk('public')->delete('features/'.$features->image);
        }

        $features = $features->delete();
        Toastr::success('Features deleted successfully','Success');
        return redirect()->back();
    }
}
