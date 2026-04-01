<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Program;
use Hash;

class ProgramController extends Controller
{
    public function listingView()
    {
        if(Auth::check()){
            return view('backend.programListing');
        }
        return redirect("/")->withError('Opps! You do not have access');
    }
    public function listing()
    {
        if(Auth::check()){
            $data = Program::get();
            return json_encode(['data' => $data]);
        }
        return redirect("/")->withError('Opps! You do not have access');
    }
    public function addProgramView()
    {
        if(Auth::check()){
            return view('backend.addProgram');
        }
        return redirect("/")->withError('Opps! You do not have access');
    }
     public function saveProgram(Request $request)
    {
        if(Auth::check()){
            $program                     = new Program();
            $program->program_name        = $request->name;
            $program->program_address     = $request->address;
            $program->program_description = $request->description;
            if($request ->hasFile('image')){
    			$program_photo      = $request->image;
    			$imageName          = time().'.'.$program_photo->extension();  
    			$program_photo->move(public_path('program_images'),$imageName);
    			$program->program_image= $imageName;
    		}
            $program->save();
            return redirect("/programListingView")->withSuccess('Program added successfully.');
        }
        return redirect("/")->withError('Opps! You do not have access');
    }
    public function unblockProgram($id = NULL)
    {
        if(Auth::check()){
            Program::where("id",$id)->update(["is_program_block" => 1]);
            $data = Program::get();
            return view('backend.programListing')->with(json_encode(['data' => $data]));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function blockProgram($id = NULL)
    {
        if(Auth::check()){
            Program::where("id",$id)->update(["is_program_block" => 0]);
            $data = Program::get();
            return view('backend.programListing')->with(json_encode(['data' => $data]));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function viewProgramDetail($id = NULL)
    {
        if(Auth::check()){
            $data     = Program::where("id",$id)->first();
            return view('backend.viewProgramDetail')->with(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
