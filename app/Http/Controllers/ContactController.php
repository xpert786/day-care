<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\{User,ContactUs};
use Hash;

class ContactController extends Controller
{
    public function listingView()                    
    {
        if(Auth::check()){
            return view('backend.ContactUs');  
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function listing()
    {
        if(Auth::check()){
            // $data = User::where("role_id",2)->get();
        $data = ContactUs::with('customer_details')->get();
            
        // dd(  $data );
        return json_encode(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
   
}
