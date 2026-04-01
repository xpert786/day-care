<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Child;
use App\Models\Token;
use Hash;
use PDF;

class CustomerAdminController extends Controller
{
    public function export_customer ()
    {
       $usersData = User::select('first_name','last_name','email','user_phone','user_address')->where('role_id',2)->get()->toArray();

       $file = fopen('public/customer_export/customer_export.csv','w');

       $header = array("First Name","Last Name","Email","Phone No.","Address");

       fputcsv($file, $header);
       foreach ($usersData as $key=>$line){
           fputcsv($file,$line);
       }

    $u =  url("public/customer_export/customer_export.csv");
    return redirect()->to($u);
    fclose($file);
    }

    public function pdf_export_customer () {
        $usersData = User::select('first_name','last_name','email','user_phone','user_address')->where('role_id',2)->get()->toArray();
        view()->share('products', $usersData);
        $pdf = PDF ::loadView ('index', $usersData);
        return $pdf->download ('customer_export.pdf');
    }

    public function listingView()
    {
        if(Auth::check()){
            return view('backend.customerListing');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function listing()
    {
        if(Auth::check()){
            $data = User::where("role_id",2)->get();
            return json_encode(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function unblock($id = NULL)
    {
        if(Auth::check()){
            User::where("user_id",$id)->update(["is_user_block" => 1]);
            $data = User::where("role_id",2)->get();
            return view('backend.customerListing')->with(json_encode(['data' => $data]));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function block($id = NULL)
    {
        if(Auth::check()){
            User::where("user_id",$id)->update(["is_user_block" => 0]);
            $data = User::where("role_id",2)->get();
            return view('backend.customerListing')->with(json_encode(['data' => $data]));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function viewCustomerDetail($id = NULL)
    {
        if(Auth::check()){
            $data     = User::where("user_id",$id)->first();
            $check    = Token::select('token')->where('tokenable_id',$id)->first();
            $children = Child::where("user_token",$check->token)->get();
            return view('backend.viewCustomerDetail')->with(['data' => $data, 'children' => $children, 'childCount' => count($children)]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
