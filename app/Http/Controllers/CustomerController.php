<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\School;
use App\Models\Program;
use App\Models\Child;
use App\Models\Token; 
use App\Models\Notify;
use App\Models\Favourite;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Report;
use App\Models\Food;
use DateTime;
use App\Models\Activity;
use App\Models\{Photos,Question,RatingReview,Attendance,Chat,ContactUs,Doc};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\{Password,Log};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function signInWithEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                if(isset($request->fcm_tokken) && !empty($request->fcm_tokken)){
                    User::where('user_id',$user->user_id)->update(['fcm_tokken' => $request->fcm_tokken]);
                }
                
                $token                 = Token::select('token')->where('tokenable_id',$user->user_id)->first();
                $success['user_token'] = $token->token;
                $success['user']       = $user;

                return response()->json(["status" => "success", "code" => 200, "message" => 'Customer logged in successfully.', 'data' => $success], 200);
            } else {
                return response()->json(["status" => "failure", "code" => 401, "message" => 'Invalid password.'], 401);
            }
        } else {
            return response()->json(["status" => "failure", "code" => 401, "message" => 'Customer does not exists.'], 401);
        }

    }
    public function signInWithPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }

        $user = User::where('user_phone', '=', $request->phone_number)->first();
        if ($user) {
            if(isset($request->fcm_tokken) && !empty($request->fcm_tokken)){
                User::where('user_id',$user->user_id)->update(['fcm_tokken' => $request->fcm_tokken]);
            }
            $user_exist            = 1;
            $otp                   = 1111;
            $token                 = Token::select('token')->where('tokenable_id',$user->user_id)->first();
            $success['user_token'] = $token->token;
            $success['user']       = $user;
            return response()->json(["status" => "success", "code" => 200, "message" => 'OTP sent successfully', "OTP" =>$otp,'user_exist' =>$user_exist, 'data' => $success], 200);
        } else {
            return response()->json(["status" => "failure", "code" => 401, "message" => 'Customer does not exists.'], 401);
        }

    }

    
    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'socialID' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }

        $user = User::where('social_id', '=', $request->socialID)->first();
        if ($user) {
            $user_exist = 1;
            $userTokens = $user->tokens;
            foreach ($userTokens as $hello) {
                $hello->delete();
            }
            $token = $user->createToken('stable token')->plainTextToken;
            $success['token'] = $token;
            $success['user'] = $user;
            return response()->json(["status" => "success", "code" => 200, "message" => 'Social ID Found','user_exist' =>$user_exist, 'data' => $success], 200);

        }
        else {
            $user_exist = 0;
            return response()->json(["status" => "success", "code" => 200, "message" => 'Social ID not Found', 'user_exist' =>$user_exist ], 200);
        }
    }

    public function signUp(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_name'    => 'required|string',
            'email'        => 'required|email|unique:users',
            'password'     => 'required',
            'user_phone'   => 'required|integer',
            'user_address' => 'required',
            'user_photo'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $user                = new User();
        $user->user_name     = $request->user_name;
        $user->email         = $request->email;
        $user->password      = bcrypt($request->password);
        $user->user_password = $request->password;
        $user->user_phone    = $request->user_phone;
        $user->user_address  = $request->user_address;
        $user->role_id       = 2;  // 2-> Customer

        if(isset($request->social_platform) && !empty($request->social_platform)){
            $user->social_status = 1;
            $user->social_id = $request->social_id;
            $user->social_platform = $request->social_platform;
        }

        else{
            $user->social_status = 0;
        }
           
        if($request ->hasFile('user_photo')){
			$user_photo      = $request->user_photo;
			$imageName       = time().'.'.$user_photo->extension();  
			$user_photo->move(public_path('customer_images'),$imageName);
			$user->user_photo= $imageName;
		}
        $user->save();

        //insert new order request in notify table

        $Notify = new Notify;
        $Notify->user_id =  $user->user_id;
        $Notify->type = 1; // 0 new customer reg     
        $Notify->save();

        $token                 = $user->createToken('Daycare Token')->plainTextToken;
        $success['user_token'] = $token;
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Customer registered successfully.', 'data' => $success], 200);

    }
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            $user_exist            = 1;
            $otp                   = 1111;
            $token                 = Token::select('token')->where('tokenable_id',$user->user_id)->first();
            $success['user_token'] = $token->token;
            $success['user']  = $user;
            return response()->json(["status" => "success", "code" => 200, "message" => 'OTP has been sent to your email successfully.', "OTP" =>$otp,'user_exist' =>$user_exist, 'data' => $success], 200);
        }
        else {
            $user_exist = 0;
            return response()->json(["status" => "success", "code" => 401, "message" => 'Customer does not exists.', 'user_exist' =>$user_exist], 401);
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'password'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }

        $token    = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        User::where('user_id', $id)->update(['password' => bcrypt($request->password),'user_password' => $request->password]);
        $user     = User::where('user_id', $id)->first();
        $token                 = Token::select('token')->where('tokenable_id',$user->user_id)->first();
        $success['user_token'] = $token->token;
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Password reset successfully.', 'data' => $success], 200);
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }

        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        
        $user     = User::where('user_id', $id)->first();
        if ($user) {
            if (Hash::check($request->old_password, $user->password)) {
                User::where('user_id', $id)->update(['password' => bcrypt($request->new_password),'user_password' => $request->new_password]); 
                $success['user_token'] = $token->token;
                $success['user']       = $user;
                return response()->json(["status" => "success", "code" => 200, "message" => 'Password changed successfully.', 'data' => $success], 200);
            }
            else
            {
                $success['user_token'] = $token->token;
                $success['user']  = $user;
                return response()->json(["status" => "success", "code" => 401, "message" => 'Old password does not match.', 'data' => $success], 401);
            }
            
        }
    }
    public function addChild(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'    => 'required|string',
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'mother_name'   => 'required|string',
            'father_name'   => 'required|string',
            'age'           => 'required',
            'gender'        => 'required',
            'dob'           => 'required',
            'child_photo'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'child_description' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $child                = new Child();
        $child->user_token    = $request->user_token;
        $child->first_name    = $request->first_name;
        $child->last_name     = $request->last_name;
        $child->mother_name   = $request->mother_name;
        $child->father_name   = $request->father_name;
        $child->age           = $request->age;
        $child->gender        = $request->gender;
        $child->dob           = $request->dob;
        $child->child_description = $request->child_description;
        if($request ->hasFile('child_photo')){
			$child_photo      = $request->child_photo;
			$imageName        = time().'.'.$child_photo->extension();  
			$child_photo->move(public_path('child_images'),$imageName);
			$child->child_photo= $imageName;
		}
		$child->save();
        $token                 = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $id                    = $token->tokenable_id;
        
        $user                  = User::where('user_id', $id)->first();
        $success['user_token'] = $request->user_token;
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child registered successfully.', 'data' => $success], 200);

    }
    public function editChildProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'    => 'required|string',
            'first_name'    => 'string',
            'last_name'     => 'string',
            'mother_name'   => 'string',
            'father_name'   => 'string',
            'age'           => 'string',
            'gender'        => 'string',
            'dob'           => 'string',
            'child_photo'   => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $child                = new Child();
        $child->user_token    = $request->user_token;
        $child->first_name    = $request->first_name;
        $child->last_name     = $request->last_name;
        $child->mother_name   = $request->mother_name;
        $child->father_name   = $request->father_name;
        $child->age           = $request->age;
        $child->gender        = $request->gender;
        $child->dob           = $request->dob;
        if($request ->hasFile('child_photo')){
			$child_photo      = $request->child_photo;
			$imageName        = time().'.'.$child_photo->extension();  
			$child_photo->move(public_path('child_images'),$imageName);
			$child->child_photo= $imageName;
		}
		$child->save();
        $token                 = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $id                    = $token->tokenable_id;
        
        $user                  = User::where('user_id', $id)->first();
        $success['user_token'] = $request->user_token;
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child registered successfully.', 'data' => $success], 200);

    }
    public function getHomeData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'    => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        
        $user     = User::where('user_id', $id)->first();
        $provider = User::where("role_id",3)->where("is_user_active","Active")->where("is_user_block",0)->get();
        // $school   = School::where('is_school_block', "Active")->get();
        // $program  = Program::where('is_program_block', "Active")->get();
        $children = Child::where("user_token",$request->user_token)->where("child_status","Active")->get();
        for($i=0;$i<count($provider);$i++)
        {
            $provider[$i]->rating = 4;
            $check_fav = Favourite::select("favourite_status")->where("user_token",$request->user_token)->where('provider_id',$provider[$i]->user_id)->first();
           if($check_fav == null){
               
                $provider[$i]->is_Fav = '0';
               
           }else{
               
                $provider[$i]->is_Fav = $check_fav->favourite_status;
               
           }
           
            // if($check_fav->favourite_status == null)
            // {
            //     $provider[$i]->is_Fav = $check_fav->favourite_status;
            // }
            // else
            // {
            //     $provider[$i]->is_Fav = $check_fav->favourite_status;
            // }
            
        }
        
        $success['user_token'] = $request->user_token;
        $success['customer_base_path']  = url('')."/public/customer_images/";
        $success['provider_base_path']  = url('')."/public/provider_images/";
        // $success['school_base_path']    = url('')."/public/school_images/";
        // $success['program_base_path']   = url('')."/public/program_images/";
        $success['children_base_path']  = url('')."/public/child_images/";
        $success['provider']   = $provider;
        // $success['school']     = $school;
        // $success['program']    = $program;
        $success['children']   = $children;
        $success['user']       = $user;

        
        return response()->json(["status" => "success", "code" => 200, "message" => 'Customer Home data fetch successfully.', 'data' => $success], 200);
        
    }
    public function makeProviderFav(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'       => 'required|string',
            'provider_id'      => 'required|string',
            'favourite_status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $check = Favourite:: where("user_token",$request->user_token)->where("provider_id",$request->provider_id)->first();
        if($check == null)
        {
            $fav                   = new Favourite();
            $fav->user_token       = $request->user_token;
            $fav->provider_id      = $request->provider_id;
            $fav->favourite_status = $request->favourite_status;
            
            $fav->save();
            return response()->json(["status" => "success", "code" => 200, "message" => 'Provider favourite status added successfully.'], 200);
        }
        else
        {
            Favourite:: where("user_token",$request->user_token)->where("provider_id",$request->provider_id)->update(['favourite_status'=>$request->favourite_status]);
            return response()->json(["status" => "success", "code" => 200, "message" => 'Provider favourite status updated successfully.'], 200);
        }
    }
    public function viewProviderDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_id'    => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        
        $provider = User::where("user_id",$request->provider_id)->first();
        $provider['rating']        = 4.9;
        $provider['reviewCount']   = count(Review:: where("provider_id",$request->provider_id)->get());
        $provider['jobsCompleted'] = 38;
        $provider['experience']    = "Lorem Ipsum";
        
        $success['provider_base_path']  = url('')."/public/provider_images/";
        $success['provider']   = $provider;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Customer Home data fetch successfully.', 'data' => $success], 200);
        
    }
    public function giveReviewToProvider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'       => 'required|string',
            'provider_id'      => 'required|string',
            'rating'           => 'required',
            'review'           => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $check = Review:: where("user_token",$request->user_token)->where("provider_id",$request->provider_id)->first();
        if($check == null)
        {
            $review              = new Review();
            $review->user_token  = $request->user_token;
            $review->provider_id = $request->provider_id;
            $review->rating      = $request->rating;
            $review->review      = $request->review;
            
            $review->save();
            return response()->json(["status" => "success", "code" => 200, "message" => 'Rating and Reviews added successfully.'], 200);
        }
        else
        {
            return response()->json(["status" => "success", "code" => 200, "message" => 'You have already given rating and review to this provider.'], 200);
        }
    }
    public function getFavouriteProviders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'       => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $ids = Favourite::select('provider_id')->where("user_token",$request->user_token)->where("favourite_status",'1')->get();
        $data = array();
        for($i=0;$i<count($ids);$i++)
        {
            $provider         = User::where("user_id",$ids[$i]->provider_id)->first();
            $data[$i]         = $provider;
            $data[$i]->rating = 4;
        }
        return response()->json(["status" => "success", "code" => 200, "message" => 'Favourite Service Providers fetch successfully.',"data" => $data], 200);
    }

    public function bookProvider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'       => 'required|string',
            'provider_id'      => 'required|string',
            'no_of_hours'     => 'required',
            'booking_start_date'     => 'required|string',
            'booking_end_date'     => 'required|string',
            'child_id'         => 'required|string'
        ]);  
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        
        $check = Booking:: where("provider_id",$request->provider_id)->where("booking_date",$request->booking_start_date)->where("booking_end_date",$request->booking_end_date)->first();
        if($check == null)
        {

            $get = User:: where("user_id",$request->provider_id)->first();
            $get_hourly_rate = $get->hourly_rate;
            $earlier = new DateTime($request->booking_start_date);
            $later = new DateTime($request->booking_end_date);
            $abs_diff = $later->diff($earlier)->format("%a"); 
            $no_days =  $abs_diff +1;
            $amount =  ($no_days*$request->no_of_hours)*$get_hourly_rate;
            // dd( $amount);

            $token    = Token::select('tokenable_id')->where('token',$request->user_token)->first();
            $user_id       = $token->tokenable_id;

            $book              = new Booking();
            $book->user_token  = $request->user_token;
            $book->user_id  =  $user_id;
            $book->provider_id = $request->provider_id;
            $book->booking_date= $request->booking_start_date;
            $book->booking_end_date= $request->booking_end_date;
            $book->child_id    = $request->child_id;
            $book->no_hours    = $request->no_of_hours;
            $book->transaction_id  = $request->transaction_id;
            $book->amount    =  $amount;
            $book->save();    

            //push notification to provider

            send_push_notification($request->provider_id,1);
            
               //END push notification to provider

            return response()->json(["status" => "success", "code" => 200, "message" => 'Service Provider book successfully.'], 200);
        }
        else
        {
            return response()->json(["status" => "success", "code" => 200, "message" => 'Service Provider not available on this date.'], 200);
        }
    }
    
      public function getbookamount(Request $request)
    {
        // print_r($request->all());die;
        $validator = Validator::make($request->all(), [
            'provider_id'      => 'required',
            'no_of_hours'     => 'required',
            'booking_start_date'     => 'required',
            'booking_end_date'     => 'required'
        ]);  
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        
       
        $check = Booking:: where("provider_id",$request->provider_id)->where("booking_date",$request->booking_start_date)->where("booking_end_date",$request->booking_end_date)->first();
        //dd($check);
        if($check == null)
        {

            $get = User:: where("user_id",$request->provider_id)->first();
            $get_hourly_rate = $get->hourly_rate;
            $earlier = new DateTime($request->booking_start_date);
            $later = new DateTime($request->booking_end_date);
            $abs_diff = $later->diff($earlier)->format("%a"); 
            $no_days =  $abs_diff +1;
            $amount =  ($no_days*$request->no_of_hours)*$get_hourly_rate;
            $provider_details = User::where('user_id',$request->provider_id)->get(); 
            $no_of_hours =  $request->no_of_hours;
            $booking_start_date =  $request->booking_start_date;
            $booking_end_date =  $request->booking_end_date;
     
            // dd( $amount);

            return response()->json(["status" => "success", "code" => 200, "amount" =>$amount, "provider details" =>$provider_details, "no_of_hours" =>$no_of_hours, "booking_start_date" =>$booking_start_date, "booking_end_date" =>$booking_end_date], 200);
        }
        else
        {
            return response()->json(["status" => "success", "code" => 200, "message" => 'Service Provider not available on this date.'], 200);
        }
    }
    
    
    public function getChildReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id'     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $data = Report::where("child_id",$request->child_id)->get();
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child progress report fetch successfully.', 'data' => $data], 200);
    }
    public function getChildMeals(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id'     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $data      = array();
        $breakfast = Food::where("child_id",$request->child_id)->where("food_time",1)->get();
        $lunch     = Food::where("child_id",$request->child_id)->where("food_time",2)->get();
        $dinner    = Food::where("child_id",$request->child_id)->where("food_time",3)->get();
        $data['breakfast'] = $breakfast;
        $data['lunch']     = $lunch;
        $data['dinner']    = $dinner;
        $base_path         = url('')."/public/food_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child meals fetch successfully.', 'data' => $data, "base_path" => $base_path], 200);
    }
    public function getChildActivities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id'     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $data       = Activity::where("child_id",$request->child_id)->get();
        $base_path  = url('')."/public/activity_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child activities fetch successfully.', 'data' => $data, "base_path" => $base_path ], 200);
    }
    public function getChildPhotos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id'     => 'required|string'
            
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $photos     = Photos::where("child_id",$request->child_id)->get();
        $base_path  = url('')."/public/child_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child photos fetch successfully.', 'data' => $photos, 'base_path' =>$base_path], 200);
    }
    public function getCustomerProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }

        $token                 = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id                    = $token->tokenable_id;
        $user                  = User::where('user_id', $id)->first();
        $success['user_token'] = $request->user_token;
        $success['base_path']  = url('')."/public/customer_images/";
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Customer profile get successfully.', 'data' => $success], 200);
    }
    public function editCustomerProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'first_name'   => 'required|string',
            'last_name'    => 'required|string',
            'user_phone'   => 'required|integer',
            'user_address' => 'required',
            'user_photo'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        if($request ->hasFile('user_photo')){
			$user_photo      = $request->user_photo;
			$imageName       = time().'.'.$user_photo->extension();  
			$user_photo->move(public_path('customer_images'),$imageName);
		}
        $token    = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        User::where('user_id', $id)->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'user_name'     => $request->first_name. " ".$request->last_name,
            'user_phone'    => $request->user_phone,
            'user_photo'    => $imageName,
            'user_address'  => $request->user_address
        ]);
        $user                  = User::where('user_id', $id)->first();
        $success['user_token'] = $request->user_token;
        $success['base_path']  = url('')."/public/customer_images/";
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Customer details updated successfully.', 'data' => $success], 200);

    }

    public function addQuestion(Request $request){

        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'question'   => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $user_id       = $token->tokenable_id;
        // dd(  $user_id );
        $user = User::where('user_id', '=',   $user_id )->exists();

        if($user){
            $question  = new Question();
            $question->user_token  = $request->user_token;
            $question->question  = $request->question;
    
            if(isset($request->answer) && !empty($request->answer)){
                $question->answer  = $request->answer;
            }
    
            $question->save();
            if ($question){
                return response()->json(["status" => "success", "code" => 200, "message" => 'Question Added successfully.', 'data' => $question], 200);
            }
            else{
                return response()->json(["status" => "failure", "code" => 500, "message" => 'Question not added.'], 500);
            }
        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid User Tokken.'], 404);
        }
    }

    public function getQuestion(Request $request){

        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $user_id       = $token->tokenable_id;

        $user = User::where('user_id', '=',   $user_id )->exists();

        if($user){
            $data  = Question::with('provider_answers','provider_answers.provider_details')->where("user_token",$request->user_token)->get();
            if(count($data) > 0){
                return response()->json(["status" => "success", "code" => 200, "message" => 'Question Fetched successfully.', 'data' => $data], 200);
            }
            else
            {
                return response()->json(["status" => "failure", "code" => 404, "message" => 'No Question Found.'], 404);
            }

        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid User Tokken.'], 404);
        }

    }

    public function feedback(Request $request){
   
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'provider_id'   => 'required|string',
            'rating'   => 'required|string',
            'review'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $user_id       = $token->tokenable_id;

        $user = User::where('user_id', '=',   $user_id )->exists();

        if($user){
            $RatingReview  = new RatingReview();
            $RatingReview->user_token  = $request->user_token;
            $RatingReview->user_id  = $user_id;
            $RatingReview->provider_id  = $request->provider_id;
            $RatingReview->rating  = $request->rating;
            $RatingReview->review  = $request->review;
  
            $RatingReview->save();
            if ($RatingReview){
                return response()->json(["status" => "success", "code" => 200, "message" => 'Feedback Saved successfully.', 'data' => $RatingReview], 200);
            }
            else{
                return response()->json(["status" => "failure", "code" => 500, "message" => 'Feedback not Saved.'], 500);
            }
        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid User Tokken.'], 404);
        }
    }

    public function getAttendenceHistory(Request $request){

        $validator = Validator::make($request->all(), [
            'child_id'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
       
        $Child = Child::where('child_id', '=',   $request->child_id )->exists();

        if($Child){
            $data  = Attendance::where("child_id",$request->child_id)->get();
            if(count($data) > 0){
                return response()->json(["status" => "success", "code" => 200, "message" => 'Attendance Fetched successfully.', 'data' => $data], 200);
            }
            else
            {
                return response()->json(["status" => "failure", "code" => 404, "message" => 'No Attendance Found.'], 404);
            }

        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid Child ID.'], 404);
        }

    }

    public function getchat(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'sender_id'   => 'required',
            'receiver_id'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
       
        $sender_id=$request->sender_id;
		$receiver_id=$request->receiver_id;

        $sender_user=Chat::where('sender_id',$sender_id)->where('received_id',$receiver_id)->with('profile')->get()->toArray();

        $receiver_user=Chat::where('sender_id',$receiver_id)->where('received_id',$sender_id)->with('profile')->get()->toArray();

        $chat = array_merge($sender_user,$receiver_user);

        // $sender_user = Chat::where('sender_id',$user_id)->with('profile')->get()->toArray();

        // $receiver_user = Chat::where('received_id',$user_id)->with('profile')->get()->toArray();

		// $chat=Chat::where('sender_id',$sender_id)->where('received_id',$receiver_id)->with('profile')->get();




        if(count($chat) > 0){
            return response()->json(["status" => "success", "code" => 200, "message" => 'Chat Fetched successfully.', 'chat' => $chat], 200);
        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'No Chat Found.'], 404);
        }

	}

    public function postchat(Request $request)
	{

        $validator = Validator::make($request->all(), [
            'sender_id'   => 'required',
            'receiver_id'   => 'required',
            'msg'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $sender_id=$request->sender_id;
		$receiver_id=$request->receiver_id;
        $msg=$request->msg;
        
        $chat=new Chat();
        $chat->sender_id=$sender_id;
        $chat->received_id=$receiver_id;
        $chat->message=$msg;
        $chat->save();

        if($chat){
            return response()->json(["status" => "success", "code" => 200, "message" => 'Msg Sent successfully.', 'sent_msg' => $chat], 200);
        }

        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Msg Not Sent.'], 404);
        }
                                             
}

    public function getUserchat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        
        $user_id= $request->user_id;
        // ->with('profile')

        $chat = Chat::where('sender_id',$user_id)->orwhere('received_id',$user_id)->with('profile')->get();
        $chat = $chat->unique('sender_id','received_id');
        $chat = $chat->values()->all();



        // $sender_user = Chat::where('sender_id',$user_id)->with('profile')->get()->toArray();

        // $receiver_user = Chat::where('received_id',$user_id)->with('profile')->get()->toArray();

        // $chat = array_merge($sender_user,$receiver_user);

        // function unique_key($array,$keyname){

        //     $new_array = array();
        //     foreach($array as $key=>$value){
           
        //       if(!isset($new_array[$value[$keyname]])){
        //         $new_array[$value[$keyname]] = $value;
        //       }
           
        //     }
        //     $new_array = array_values($new_array);
        //     return $new_array;
        //    }
           

        // $chat = unique_key($chat,'sender_id','received_id');

        // $chat =   array_unique($chat, SORT_REGULAR);

        // $chat = array_unique(array_column($chat, 'sender_id','received_id'));

        // $chat =  $chat->array_unique('sender_id','received_id');

        // $chat = $mergedArray->array_unique('sender_id','received_id') ;

        // $sender_user = Chat::where('sender_id',$user_id)->with('profile')->get();

        // $receiver_user = Chat::where('received_id',$user_id)->with('profile')->get();

        // $chat = $sender_user->merge($receiver_user)->unique('sender_id','received_id');

        $base_path         = url('')."/public/customer_images/";

        if(count($chat) > 0){
            return response()->json(["status" => "success", "code" => 200, "message" => 'Chat Fetched successfully.', 'chat' => $chat , 'base_path' => $base_path], 200);
        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'No Chat Found.'], 404);
        }

    }


    public function postContactUs(Request $request)
	{

        $validator = Validator::make($request->all(), [
            'user_token'   => 'required',
            'role_id'   => 'required',
            'msg'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $user_token=$request->user_token;
		$role_id=$request->role_id;
        $msg=$request->msg;

        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $user_id       = $token->tokenable_id;
        
        $ContactUs=new ContactUs();
        $ContactUs->user_token=$user_token;
        $ContactUs->user_id  = $user_id;
        $ContactUs->role_id=$role_id;
        $ContactUs->message=$msg;
        $ContactUs->save();

        if($ContactUs){
            return response()->json(["status" => "success", "code" => 200, "message" => 'Data Submitted successfully.', 'sent_msg' => $ContactUs], 200);
        }

        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Not Submitted.'], 404);
        }
                                             
}

    public function uploaddoc(Request $request){

        $validator = Validator::make($request->all(), [
            'child_id'   => 'required',
            'doc'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $Child = Child::where('child_id', '=',   $request->child_id )->exists();

        if($Child){
            $Doc= new Doc();
            $Doc->child_id= $request->child_id;
            if($request ->hasFile('doc')){
                $user_photo      = $request->doc;
                $imageName       = time().'.'.$user_photo->extension();  
                $user_photo->move(public_path('customer_images'),$imageName);
                $Doc->filename= $imageName;
            }
            $Doc->save();
            $base_path         = url('')."/public/customer_images/";
            return response()->json(["status" => "success", "code" => 200, "message" => 'Document Uploaded Successfully.', 'data' => $Doc, 'base_path' => $base_path], 200);
                }

                else
                {
                    return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid Child ID.'], 404);
                }
        
    }

    public function getdoc(Request $request){

        $validator = Validator::make($request->all(), [
            'child_id'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $Child = Child::where('child_id', '=',   $request->child_id )->exists();

        if($Child){
            $Doc=  Doc::where('child_id', '=',   $request->child_id )->get();
            $base_path         = url('')."/public/customer_images/";
            return response()->json(["status" => "success", "code" => 200, "message" => 'Document Fetched Successfully.', 'data' => $Doc, 'base_path' => $base_path], 200);
                }

                else
                {
                    return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid Child ID.'], 404);
                }
    }

    
    public function deldoc(Request $request){

        $validator = Validator::make($request->all(), [
            'doc_id'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $Doc = Doc::where('id', '=',   $request->doc_id )->first();

        if($Doc){
            $Doc=  $Doc->delete();
            return response()->json(["status" => "success", "code" => 200, "message" => 'Document Deleted Successfully.'], 200);
                }
                else
                {
                    return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid Doc ID.'], 404);
                }
    }

    public function getAllContracts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $cus_token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();

        if($cus_token){
                                
            $requests = Booking::where("user_token",$request->user_token)->get();
                                   
            if(count($requests) > 0)
            {
                $base_path  = url('')."/public/customer_images/";
                  return response()->json(["status" => "success", "code" => 200, "message" => 'All contracts fetch successfully.', 'data' => $requests, 'base_path' =>$base_path], 200);
            }
            else
            {
                return response()->json(["status" => "failure", "code" => 404, "message" => 'No contracts Found.'], 404);
            }

        }

        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid User Tokken.'], 404);
        }
      
       
    }

}