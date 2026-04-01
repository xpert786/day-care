<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\School;
use Hash;

class SchoolController extends Controller
{
    public function listingView()
    {
        if(Auth::check()){
            return view('backend.schoolListing');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function listing()
    {
        if(Auth::check()){
            $data = School::get();
            return json_encode(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function addSchoolView()
    {
        if(Auth::check()){
            return view('backend.addSchool');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
     public function saveSchool(Request $request)
    {
        if(Auth::check()){
            $school                     = new School();
            $school->school_name        = $request->name;
            $school->school_board       = $request->board;
            $school->school_classes     = $request->classes;
            $school->school_residential = $request->residential;
            $school->school_ownership   = $request->ownership;
            $school->school_campus_size = $request->campusSize;
            $school->school_highest_grade = $request->highestGrade;
            $school->opening_year         = $request->openingYear;
            $school->neighborhood_hotel   = $request->hotel;
            $school->neighborhood_museum  = $request->meuseum;
            $school->neighborhood_park    = $request->park;
            $school->neighborhood_hospital= $request->hospital;
            $school->school_address       = $request->address;
            $school->school_description   = $request->description;
            if($request ->hasFile('image')){
    			$school_photo      = $request->image;
    			$imageName         = time().'.'.$school_photo->extension();  
    			$school_photo->move(public_path('school_images'),$imageName);
    			$school->school_image= $imageName;
    		}
            $school->save();
            return redirect("/schoolListingView")->withSuccess('School added successfully.');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function unblockSchool($id = NULL)
    {
        if(Auth::check()){
            School::where("id",$id)->update(["is_school_block" => 1]);
            $data = School::get();
            return view('backend.schoolListing')->with(json_encode(['data' => $data]));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function blockSchool($id = NULL)
    {
        if(Auth::check()){
            School::where("id",$id)->update(["is_school_block" => 0]);
            $data = School::get();
            return view('backend.schoolListing')->with(json_encode(['data' => $data]));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function viewSchoolDetail($id = NULL)
    {
        if(Auth::check()){
            $data     = School::where("id",$id)->first();
            return view('backend.viewSchoolDetail')->with(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
