<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\{User,Notify,Commission,Booking,Analytics};
use Hash;

class AuthController extends Controller
{

    public function postLogin(Request $request)
    {   
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $role_id = Auth::user()->role_id;
            if($role_id == 1){
                return redirect()->intended('dashboard');
            }
            else{
                return redirect("/")->withError('Oops! You have entered invalid credentials');
            }

        }

        return redirect("/")->withError('Oops! You have entered invalid credentials');
    }

    public function dashboard()
    {
        if(Auth::check()){
            $name          = Auth::user()->user_name;
            $users         = User::where("role_id",2)->take(5)->orderBy('user_id','desc')->get();
            $userCount     = count($users);
            
            $providers      = User::where("role_id",3)->take(5)->orderBy('user_id','desc')->get();
            $providerCount  = count($providers);
            return view('backend.dashboard')->with(["users"=>$users, "userCount"=>$userCount, "providers"=>$providers, "providerCount"=>$providerCount]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
    public function editAdminProfile()
    {
        if(Auth::check()){
            $data  = User::where("user_id",Auth::user()->user_id)->first();
            return view('backend.editAdminProfile')->with(["data"=>$data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function updateAdminProfile(Request $request)
    {
        if(Auth::check()){
            User::where("user_id",Auth::user()->user_id)->update(["user_name" => $request->name, "user_phone" => $request->phone]);
            return redirect("/dashboard")->withSuccess('Profile details updated successfully.');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function changePassword()
    {
        if(Auth::check()){
            return view('backend.changePassword');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function updatePassword(Request $request)
    {
        if(Auth::check()){
            $check = User::where("user_id",Auth::user()->user_id)->where("user_password",$request->old)->first();
            if($check == null)
            {
                return redirect("/changePassword")->withError('Opps! Invalid old password.');
            }
            else
            {
                User::where("user_id",Auth::user()->user_id)->update(["user_password" => $request->newPassword, "password" => bcrypt($request->newPassword)]);
                Session::flush();
                Auth::logout();
                return Redirect('/');
            }
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function notifications()
    {
        Notify::query()->update(['status' => 1]);
        return view('backend.notifications');
    }

    public function dynamicnotifiy()
    {
        $notifications = Notify::orderBy('id', 'DESC')->get();
        return view('backend.dynamicnotifiy',compact('notifications'));
    }

    public function countnotifiy()
    {
        $noti_count = \App\Models\Notify::where('status', '=', 0)->get();
        return count($noti_count);
    }

    
    public function gettotalearning()
    {
        $i=0; $j=0;
        $comm_per = Commission::find(1);
        $comm_per = $comm_per->percentage;
        $dailyRev  = Booking::all();
        foreach($dailyRev as $dailyRevs){
        $grand_tot_per = ($dailyRevs->amount * $comm_per )/100;
        $i = $i +  $grand_tot_per;
       }

       $month = date('m');
       $yr = date('Y');
       $curr_mon_ear  = Booking::whereMonth("updated_at", $month)->whereYear("updated_at", $yr)->get();

       foreach($curr_mon_ear as $curr_mon_ear){
       $grand_tot_per = ($curr_mon_ear->amount * $comm_per )/100;
       $j = $j +  $grand_tot_per;
         }
        return view('backend.account.account_details')->with(["i"=>$i,"j"=>$j]);
    }

    public function get_mon_earn(Request $request){

        $j=0;
        $comm_per = Commission::find(1);
        $comm_per = $comm_per->percentage;
        $month = $request->get_mon;
       $yr = date('Y');
       if(isset($request->dt)){
        $dt = $request->date;
        // $date = date_format($dt,"Y-m-d");
        // echo $date;
        $dailyRev  = Booking::whereDate("updated_at",$dt)->get();
        // echo  $dailyRev ;exit;
        foreach($dailyRev as $dailyRev){
            $grand_tot_per = ($dailyRev->amount * $comm_per )/100;
            $j = $j +  $grand_tot_per;
              }
              echo $j;
      }
      else{
        $curr_mon_ear  = Booking::whereMonth("updated_at", $month)->whereYear("updated_at", $yr)->get();
        foreach($curr_mon_ear as $curr_mon_ear){
        $grand_tot_per = ($curr_mon_ear->amount * $comm_per )/100;
        $j = $j +  $grand_tot_per;
          }
          echo $j;
         }
      }

      public function followersdata(){          

        $curr_yr = date('Y');
        $curr_mon = date('m');
        $j=0;

        for($i=1;$i<=12;$i++){

        //update users_reg

        $individual_mon_user_reg  = User::where("role_id",2)->whereMonth("created_at",$i)->whereYear("created_at",'=',$curr_yr)->get();
        $count_individual_mon_user_reg  = count($individual_mon_user_reg);
        Analytics::where('id', $i)->update(['users_reg' => $count_individual_mon_user_reg]);

        //update rev gen

        $individual_mon_dailyRev  = Booking::whereMonth("updated_at",$i)->whereYear("updated_at",'=',$curr_yr)->get();
        foreach($individual_mon_dailyRev as $individual_mon_dailyRev){
            $j = $j + $individual_mon_dailyRev->amount;
        }
        Analytics::where('id', $i)->update(['rev_gen' => $j]);

        //update order plc

        $individual_mon_order_plc  = Booking::whereMonth("created_at",$i)->whereYear("created_at",'=',$curr_yr)->get();
        $count_individual_mon_order_plc  = count($individual_mon_order_plc);
        Analytics::where('id', $i)->update(['ord_plc'=> $count_individual_mon_order_plc]);

        }

        $query = Analytics::select("mon", "users_reg", "rev_gen", "ord_plc")->get();
        return $query;
	}

    public function allData(){   
        if(Auth::check()){
            $data = Booking::with('customer_details','provider_details')->get();
            return json_encode(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access'); 

    }
    

}
