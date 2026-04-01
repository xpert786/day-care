<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use PDF;

class ProviderController extends Controller
{

    public function export_provider ()
    {
       $usersData = User::select('first_name','last_name','email','user_phone','user_address')->where('role_id',3)->get()->toArray();

       $file = fopen('public/provider_export/provider_export.csv','w');

       $header = array("First Name","Last Name","Email","Phone No.","Address");

       fputcsv($file, $header);
       foreach ($usersData as $key=>$line){
           fputcsv($file,$line);
       }

    $u =  url("public/provider_export/provider_export.csv");
    return redirect()->to($u);
    fclose($file);
    }

    public function pdf_export_provider () {
        $usersData = User::select('first_name','last_name','email','user_phone','user_address')->where('role_id',3)->get()->toArray();
        view()->share('products', $usersData);
        $pdf = PDF ::loadView ('provider', $usersData);
        return $pdf->download ('provider_export.pdf');
    }
    
    public function listingView()
    {
        if(Auth::check()){
            return view('backend.providerListing');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function listing()
    {
        if(Auth::check()){
            $data = User::where("role_id",3)->orderBy('user_id','desc')->get();
            return json_encode(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function addProviderView()
    {
        if(Auth::check()){
            return view('backend.addProvider');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function saveProvider(Request $request)
    {
        if(Auth::check()){
            $data = User::where("role_id",3)->where('email',$request->email)->get();
            if(count($data)>0)
            {
                return redirect("/addProviderView")->withError('Email already exists.');
            }
            else
            {
                $user                = new User();
                $user->first_name    = $request->first_name;
                $user->last_name     = $request->last_name;
                $user->user_name     = $request->first_name. " ".$request->last_name;
                $user->email         = $request->email;
                $user->user_age      = $request->user_age;
                $user->password      = bcrypt("123456");
                $user->user_password = "123456";
                $user->user_phone    = $request->user_phone;
                $user->user_location = $request->user_location;
                $user->user_address  = $request->user_address;
                $user->user_service_type  = $request->user_service_type;
                $user->services_offered   = $request->services_offered;
                $user->hourly_rate        = $request->hourly_rate;
                $user->description        = $request->description;
                $user->certification      = $request->certification;
                $user->role_id            = 3;  // 3-> Provider
                if($request ->hasFile('user_photo')){
                                    			$user_photo      = $request->user_photo;
        			$imageName       = time().'.'.$user_photo->extension();  
        			$user_photo->move(public_path('provider_images'),$imageName);
        			$user->user_photo= $imageName;
        		}
                $user->save();
                return redirect("/providerListingView")->withSuccess('Service Provider added successfully.');
            }
        }
        return redirect("/")->withError('Opps! You do not have access');
    }
    public function unblockProvider($id = NULL)
    {
        if(Auth::check()){
            User::where("user_id",$id)->update(["is_user_block" => 1]);
            $data = User::where("role_id",3)->get();
            return view('backend.providerListing')->with(json_encode(['data' => $data]));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function blockProvider($id = NULL)
    {
        if(Auth::check()){
            User::where("user_id",$id)->update(["is_user_block" => 0]);
            $data = User::where("role_id",3)->get();
            return view('backend.providerListing')->with(json_encode(['data' => $data]));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function viewProviderDetail($id = NULL)
    {
        if(Auth::check()){
            $data     = User::where("user_id",$id)->first();
            return view('backend.viewProviderDetail')->with(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
