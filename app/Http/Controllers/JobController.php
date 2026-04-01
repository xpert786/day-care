<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Child;
use App\Models\Booking;
use App\Models\Token;
use Hash;

class JobController extends Controller
{
    public function listingView()
    {
        if(Auth::check()){
            return view('backend.ongoingJobListing');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function listing()
    {
        if(Auth::check()){
            $data = Booking::where("booking_status",2)->orderBy("booking_date","DESC")->get();
            if(count($data) > 0)
            {
                for($i=0;$i<count($data);$i++)
                {
                    $provider = User::select('user_name')->where("user_id",$data[$i]->provider_id)->first();
                    $data[$i]->provider_name = $provider->user_name;
                    
                    $check    = Token::select('tokenable_id')->where('token',$data[$i]->user_token)->first();
                    $customer = User::select('user_name')->where("user_id",$check->tokenable_id)->first();
                    $data[$i]->customer_name = $customer->user_name;
                    $data[$i]->customer_id   = $check->tokenable_id;
                }
            }
            return json_encode(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function upcomingJobListingView()
    {
        if(Auth::check()){
            return view('backend.upcomingJobListing');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function upcomingJobListing()
    {
        if(Auth::check()){
            $data = Booking::where("booking_status",1)->orderBy("booking_date","DESC")->get();
            if(count($data) > 0)
            {
                for($i=0;$i<count($data);$i++)
                {
                    $provider = User::select('user_name')->where("user_id",$data[$i]->provider_id)->first();
                    $data[$i]->provider_name = $provider->user_name;
                    
                    $check    = Token::select('tokenable_id')->where('token',$data[$i]->user_token)->first();
                    $customer = User::select('user_name')->where("user_id",$check->tokenable_id)->first();
                    $data[$i]->customer_name = $customer->user_name;
                    $data[$i]->customer_id   = $check->tokenable_id;
                }
            }
            return json_encode(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function pastJobListingView()
    {
        if(Auth::check()){
            return view('backend.pastJobListing');
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function pastJobListing()
    {
        if(Auth::check()){
            $data = Booking::where("booking_status",4)->orderBy("booking_date","DESC")->get();
            if(count($data) > 0)
            {
                for($i=0;$i<count($data);$i++)
                {
                    $provider = User::select('user_name')->where("user_id",$data[$i]->provider_id)->first();
                    $data[$i]->provider_name = $provider->user_name;
                    
                    $check    = Token::select('tokenable_id')->where('token',$data[$i]->user_token)->first();
                    $customer = User::select('user_name')->where("user_id",$check->tokenable_id)->first();
                    $data[$i]->customer_name = $customer->user_name;
                    $data[$i]->customer_id   = $check->tokenable_id;
                }
            }
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
    public function bookingDetail($id = NULL)
    {
        if(Auth::check()){
            $data     = Booking::where("id",$id)->first();
            $provider = User::select('user_name')->where("user_id",$data->provider_id)->first();
            $data->provider_name = $provider->user_name;
            
            $check    = Token::select('tokenable_id')->where('token',$data->user_token)->first();
            $customer = User::select('user_name')->where("user_id",$check->tokenable_id)->first();
            $data->customer_name = $customer->user_name;
            return view('backend.viewBookingDetail')->with(['data' => $data]);
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
