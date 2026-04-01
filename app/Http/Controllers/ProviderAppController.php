<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Food;
use App\Models\Photos;
use App\Models\Token;
use App\Models\Child;
use App\Models\Booking;
use App\Models\Notify;
use App\Models\Attendance;
use App\Models\{Activity,QuestionAns,ParentBehaviour,Question,ReportCus,Download};
use App\Models\Report;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProviderAppController extends Controller
{

    public function psignInWithEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', '=', $request->email)->where('role_id',3)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token                 = Token::select('token')->where('tokenable_id',$user->user_id)->first();
                $success['user_token'] = $token->token;
                $success['base_path']  = url('')."/public/provider_images/";
                $success['user']       = $user;
                return response()->json(["status" => "success", "code" => 200, "message" => 'Service Provider logged in successfully.', 'data' => $success], 200);
            } else {
                return response()->json(["status" => "failure", "code" => 401, "message" => 'Invalid password.'], 401);
            }
        } else {
            return response()->json(["status" => "failure", "code" => 401, "message" => 'Service Provider does not exists.'], 401);
        }

    }
    public function psignUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
          /*   'first_name'   => 'required|string',
            'last_name'    => 'required|string',
            'user_age'     => 'required|string', */
            'email'        => 'required|email|unique:users'
            /* 'password'     => 'required',
            'user_phone'   => 'required|integer',
            'user_location'     => 'required',
            'user_address'      => 'required',
            'user_service_type' => 'required',
            'services_offered'  => 'required',
            'hourly_rate'       => 'required',
            'description'       => 'required',
            'certification'     => 'required',
            'license_img'     => 'required',
            'license_no'     => 'required' */
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $user                = new User();
        $user->first_name    = $request->first_name;
        $user->last_name     = $request->last_name;
        $user->user_name     = $request->first_name. " ".$request->last_name;
        $user->email         = $request->email;
        $user->user_age      = $request->user_age;
        $user->password      = bcrypt($request->password);
        $user->user_password = $request->password;
        $user->user_phone    = $request->user_phone;
        $user->user_location = $request->user_location;
        $user->user_address  = $request->user_address;
        $user->user_service_type  = $request->user_service_type;
        $user->services_offered   = $request->services_offered;
        $user->hourly_rate        = $request->hourly_rate;
        $user->description        = $request->description;
        $user->certification      = $request->certification;
        $user->lic_no      = $request->license_no;
        $user->role_id            = 3;  // 3-> Provider
        if($request ->hasFile('user_photo')){
			$imageName       = "user.png";
			$user_photo->move(public_path('provider_images'),$imageName);
			$user->user_photo= $imageName;
		}
        if($request ->hasFile('license_img')){
            $file = $request->file('license_img');
            $extension = $file->getClientOriginalExtension();
            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                $imageName = time() . '.' . $extension;
                $request->license_img->move(public_path('provider_images'),$imageName);
                $user->lic_img= $imageName;
            }
		}
                                      
        $user->save();

                //insert new order request in notify table

                $Notify = new Notify;
                $Notify->user_id =  $user->user_id;
                $Notify->type = 2; // 0 new ser pro reg     
                $Notify->save();
        

        $token                 = $user->createToken('Daycare Token')->plainTextToken;
        $success['user_token'] = $token;
        $success['base_path']  = url('')."/public/provider_images/";
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Service Provider registered successfully.', 'data' => $success], 200);

    }
    public function pforgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', '=', $request->email)->where("role_id",3)->first();
        if ($user) {
            $user_exist            = 1;
            $otp                   = 1111;
            $token                 = Token::select('token')->where('tokenable_id',$user->user_id)->first();
            $success['user_token'] = $token->token;
            $success['base_path']  = url('')."/public/provider_images/";
            $success['user']       = $user;
            return response()->json(["status" => "success", "code" => 200, "message" => 'OTP has been sent to your email successfully.', "OTP" =>$otp,'user_exist' =>$user_exist, 'data' => $success], 200);
        }
        else {
            $user_exist = 0;
            return response()->json(["status" => "failure", "code" => 401, "message" => 'Service Provider not found', 'user_exist' =>$user_exist], 401);
        }
    }
    public function presetPassword(Request $request)
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
        $success['base_path']  = url('')."/public/provider_images/";
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Password reset successfully.', 'data' => $success], 200);
    }
    public function pchangePassword(Request $request)
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
                $success['base_path']  = url('')."/public/provider_images/";
                $success['user']       = $user;
                return response()->json(["status" => "success", "code" => 200, "message" => 'Password changed successfully.', 'data' => $success], 200);
            }
            else
            {
                $success['user_token'] = $token->token;
                $success['user']  = $user;
                return response()->json(["status" => "failure", "code" => 401, "message" => 'Old password does not match.', 'data' => $success], 401);
            }
            
        }
    }
    public function pgetProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 422, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 422);
        }

        $token    = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        $user     = User::where('user_id', $id)->first();
        $success['user_token'] = $request->user_token;
        $success['base_path']  = url('')."/public/provider_images/";
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Service Provide profile get successfully.', 'data' => $success], 200);
    }
    public function peditProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'first_name'   => 'required|string',
            'last_name'    => 'required|string',
            'user_age'     => 'required|string',
            'user_phone'   => 'required|integer',
            'user_location'     => 'required',
            'user_address'      => 'required',
            'user_service_type' => 'required',
            'services_offered'  => 'required',
            'hourly_rate'       => 'required',
            'description'       => 'required',
            'certification'     => 'required',
            'user_photo'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        if($request ->hasFile('user_photo')){
			$user_photo      = $request->user_photo;
			$imageName       = time().'.'.$user_photo->extension();  
			$user_photo->move(public_path('provider_images'),$imageName);
		}
        $token    = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        User::where('user_id', $id)->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'user_name'     => $request->first_name. " ".$request->last_name,
            'user_age'      => $request->user_age,
            'user_phone'    => $request->user_phone,
            'user_photo'    => $imageName,
            'user_location' => $request->user_location,
            'user_address'  => $request->user_address,
            'user_service_type'  => $request->user_service_type,
            'services_offered'   => $request->services_offered,
            'hourly_rate'        => $request->hourly_rate,
            'description'        => $request->description,
            'certification'      => $request->certification
        ]);
        $user                  = User::where('user_id', $id)->first();
        $success['user_token'] = $request->user_token;
        $success['base_path']  = url('')."/public/provider_images/";
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Service Provider details updated successfully.', 'data' => $success], 200);

    }
    public function addFood(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'child_id'     => 'required|string',
            'food_name'    => 'required|string',
            'description'  => 'required|string',
            'ftime'        => 'required|string',
            'food_photo'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'food_time'    => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $food                = new Food();
        $food->user_token    = $request->user_token;
        $food->child_id      = $request->child_id;
        $food->food_name     = $request->food_name;
        $food->description   = $request->description;
        $food->ftime         = $request->ftime;
        $food->food_time     = $request->food_time;
        if($request ->hasFile('food_photo')){
			$food_photo      = $request->food_photo;
			$imageName       = time().'.'.$food_photo->extension();  
			$food_photo->move(public_path('food_images'),$imageName);
			$food->food_photo=$imageName;
		}
        $food->save();
        
        $token    = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        $user     = User::where('user_id', $id)->first();
        
        $success['user_token'] = $request->user_token;
        $success['base_path']  = url('')."/public/provider_images/";
        $success['user']       = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Food Added successfully.', 'data' => $success], 200);

    }
    public function getFoodDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'    => 'required|string',
            'child_id'      => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        
        $user      = User::where('user_id', $id)->first();
        $breakfast = Food::where("user_token",$request->user_token)->where("child_id",$request->child_id)->where("status",1)->where("food_time",1)->get();
        $lunch     = Food::where("user_token",$request->user_token)->where("child_id",$request->child_id)->where("status",1)->where("food_time",2)->get();
        $dinner    = Food::where("user_token",$request->user_token)->where("child_id",$request->child_id)->where("status",1)->where("food_time",3)->get();
        
        $success['user_token']          = $request->user_token;
        $success['provider_base_path']  = url('')."/public/provider_images/";
        $success['food_base_path']      = url('')."/public/food_images/";
        $success['breakfast']           = $breakfast;
        $success['lunch']               = $lunch;
        $success['dinner']              = $dinner;
        $success['user']                = $user;
        return response()->json(["status" => "success", "code" => 200, "message" => 'Food details fetch successfully.', 'data' => $success], 200);
        
    }
    public function addPhotos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'child_id'     => 'required|string',
            'child_photo'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $photo                = new Photos();
        $photo->user_token    = $request->user_token;
        $photo->child_id      = $request->child_id;
        if($request ->hasFile('child_photo')){
            $child_photo      = $request->child_photo;
			$imageName        = time().'.'.$child_photo->extension();  
			$child_photo->move(public_path('child_images'),$imageName);
			$photo->child_photo=$imageName;
		}
        $photo->save();
        $base_path = url('')."/public/child_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child photo uploaded successfully.', 'base_path' => $base_path], 200);
    }
    public function getRequests(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $token    = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        
        $requests = Booking::where("provider_id",$id)->where("booking_status",1)->get();

        for($i=0;$i<count($requests);$i++)
        {
            // dd($requests[$i]->user_token);
            $cus_token  = Token::select('tokenable_id')->where('token',$requests[$i]->user_token)->first();
            if (is_null( $cus_token)){

            }
            else{
                $cus_id     = $cus_token->tokenable_id;
                $cus        = User::where("user_id",$cus_id)->first();
                $requests[$i]->customer_detail = $cus;
            }
        
        }
                   
        $base_path  = url('')."/public/customer_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'Booking Requests fetch successfully.', 'data' => $requests, 'base_path' =>$base_path], 200);
    }

    public function getPhotos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'child_id'     => 'required|string'
            
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $photos = Photos::where("user_token",$request->user_token)->where("child_id",$request->child_id)->get();
        $base_path  = url('')."/public/child_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child photos fetch successfully.', 'data' => $photos, 'base_path' =>$base_path], 200);
    }

    public function changeBookingStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_status' => 'required|string',
            'booking_id'     => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

      $get_booking_data = Booking::where("id",$request->booking_id)->first();
      $get_user_token =  $get_booking_data->user_token;

  

      $cus_token  = Token::select('tokenable_id')->where('token',$get_user_token)->first();
      $cus_id     = $cus_token->tokenable_id;


        if ($request->booking_status == 2){
            
            //push notification to provider
            send_push_notification($cus_id,2);

        }
        
        elseif ($request->booking_status == 3){
            
            //push notification to provider
            send_push_notification($cus_id,3);
        }

        elseif ($request->booking_status == 4){

            //push notification to provider
            send_push_notification($cus_id,4);
        }

        Booking::where("id",$request->booking_id)->update(["booking_status"=>$request->booking_status]);
        return response()->json(["status" => "success", "code" => 200, "message" => 'Booking status updated successfully.'], 200);
    }

    public function getChildDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id'   => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $child = Child::where("child_id",$request->child_id)->get();
        
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child Details fetch successfully.', 'data' => $child], 200);
    }
    public function getAllChildren(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $token  = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id     = $token->tokenable_id;
        
        $getBookingDetail = Booking::where("provider_id",$id)->where("booking_status",2)->get();
        if(count($getBookingDetail)>0)
        {
            for($i=0;$i<count($getBookingDetail);$i++)
            {
                $child                            = Child::where("user_token",$getBookingDetail[$i]->user_token)->where("is_deleted_by_provider","0")->first();
                $getBookingDetail[$i]->child_info = $child;
            }
            $base_path  = url('')."/public/child_images/";
            return response()->json(["status" => "success", "code" => 200, "message" => 'Child Details fetch successfully.', 'data' => $getBookingDetail, 'base_path' =>$base_path], 200);
        }
        else
        {
            $getBookingDetail = [];
            return response()->json(["status" => "success", "code" => 200, "message" => 'No child found.', 'data' => $getBookingDetail], 200);
        }
    }
    public function getAllChildrenAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'child_id'     => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $child                = Child::where("child_id",$request->child_id)->first();
        $attendance           = Attendance::select("checkIn_time","checkOut_time","attendance_date")->where("checkIn_time","!=",null)->where("checkOut_time","=",null)->where("user_token",$request->user_token)->where("child_id",$request->child_id)->orderBy("attendance_date","DESC")->get();
        $child->attendance    = $attendance;
        $base_path  = url('')."/public/child_images/"; 
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child Details fetch successfully.', 'data' => $child, 'base_path' =>$base_path], 200);
    }
    public function checkIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id'     => 'required|string',
            'user_token'   => 'required|string',
            'checkIn_time' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        
        $check = Attendance::select("checkIn_time")->where("child_id",$request->child_id)->where("user_token",$request->user_token)->where("attendance_date",date("d/m/Y"))->first();
        if($check == null)
        {
            $attendance                  = new Attendance();
            $attendance->user_token      = $request->user_token;
            $attendance->child_id        = $request->child_id;
            $attendance->checkIn_time    = $request->checkIn_time;
            $attendance->attendance_date = date("d/m/Y");
            $attendance->save();
            return response()->json(["status" => "success", "code" => 200, "message" => 'Child check in successfully.'], 200);
        }
        else
        {
            return response()->json(["status" => "success", "code" => 200, "message" => 'Child is already checked in.'], 200);
        }
    }
    public function checkOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id'      => 'required|string',
            'user_token'    => 'required|string',
            'checkOut_time' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        
        $check = Attendance::select("checkOut_time")->where("child_id",$request->child_id)->where("user_token",$request->user_token)->where("attendance_date",date("d/m/Y"))->first();
        if($check->checkOut_time == null)
        {
            Attendance::where("child_id",$request->child_id)->where("user_token",$request->user_token)->where("attendance_date",date("d/m/Y"))->update(["checkOut_time"=>$request->checkOut_time]);
            
            return response()->json(["status" => "success", "code" => 200, "message" => 'Child check out successfully.'], 200);
        }
        else
        {
            return response()->json(["status" => "success", "code" => 200, "message" => 'Child is already checked out.'], 200);
        }
    }
    public function addActivity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'      => 'required|string',
            'child_id'        => 'required|string',
            'activity_name'   => 'required|string',
            'rating'          => 'required|string',
            'activity_photo'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $activity                = new Activity();
        $activity->user_token    = $request->user_token;
        $activity->child_id      = $request->child_id;
        $activity->activity_name = $request->activity_name;
        $activity->rating        = $request->rating;
        if($request ->hasFile('activity_photo')){
			$activity_photo  = $request->activity_photo;
			$imageName       = time().'.'.$activity_photo->extension();  
			$activity_photo->move(public_path('activity_images'),$imageName);
			$activity->activity_photo=$imageName;
		}
        $activity->save();
        
        return response()->json(["status" => "success", "code" => 200, "message" => 'Activity Added successfully.'], 200);
    }
    public function getActivities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'      => 'required|string',
            'child_id'        => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $activities = Activity::where("user_token",$request->user_token)->where("child_id",$request->child_id)->get();
        $base_path  = url('')."/public/activity_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child Activities fetch successfully.', "data" => $activities, "base_path" => $base_path ], 200);
    }
    public function getAllContracts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $token    = Token::select('tokenable_id')->where('token',$request->user_token)->first();
        $id       = $token->tokenable_id;
        
        $requests = Booking::where("provider_id",$id)->get();
        for($i=0;$i<count($requests);$i++)
        {
            $cus_token  = Token::select('tokenable_id')->where('token',$requests[$i]->user_token)->first();
            $cus_id     = $cus_token->tokenable_id;
            $cus        = User::where("user_id",$cus_id)->first();
            $requests[$i]->customer_detail = $cus;
        }
        $base_path  = url('')."/public/customer_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'All contracts fetch successfully.', 'data' => $requests, 'base_path' =>$base_path], 200);
    }
    public function getContractDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contract_id'   => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $requests   = Booking::where("id",$request->contract_id)->first();
        $cus_token  = Token::select('tokenable_id')->where('token',$requests->user_token)->first();
        $cus_id     = $cus_token->tokenable_id;
        $cus        = User::where("user_id",$cus_id)->first();
        $requests->customer_detail = $cus;
        $base_path  = url('')."/public/customer_images/";
        return response()->json(["status" => "success", "code" => 200, "message" => 'Contract detail fetch successfully.', 'data' => $requests, 'base_path' =>$base_path], 200);
    }
    public function addReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'  => 'required|string',
            'child_id'    => 'required',
            'report_name' => 'required|string',
            'marks'       => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $report                = new Report();
        $report->user_token    = $request->user_token;
        $report->child_id      = $request->child_id;
        $report->report_name   = $request->report_name;
        $report->marks         = $request->marks;
		$report->save();
        
        return response()->json(["status" => "success", "code" => 200, "message" => 'Report added successfully.'], 200);

    }
    public function getReportInProvider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'child_id'     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        $data = Report::where("user_token",$request->user_token)->where("child_id",$request->child_id)->get();
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child progress report fetch successfully.', 'data' => $data], 200);
    }
    public function deleteChild(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }
        Child::where("child_id",$request->child_id)->update(["is_deleted_by_provider" => "1"]);
        return response()->json(["status" => "success", "code" => 200, "message" => 'Child deleted successfully.'], 200);
    }

    
    public function postAnswer(Request $request){

        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'question_id'   => 'required|string',
            'answer'   => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $user_id       = $token->tokenable_id;
        // dd(  $user_id );
        $user = User::where('user_id', '=',   $user_id )->exists();

        if($user){
            $question  = new QuestionAns();
            $question->user_token  = $request->user_token;
            $question->user_id  = $user_id;
            $question->question_id  = $request->question_id;
            
            if(isset($request->answer) && !empty($request->answer)){
                $question->answer  = $request->answer;
            }
    
            $question->save();
            if ($question){
                return response()->json(["status" => "success", "code" => 200, "message" => 'Answer Posted successfully.', 'data' => $question], 200);
            }
            else{
                return response()->json(["status" => "failure", "code" => 500, "message" => 'Answer not Posted.'], 500);
            }
        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid User Tokken.'], 404);
        }
    }

    public function postParentBehaviour(Request $request){

        $validator = Validator::make($request->all(), [
            'user_token'   => 'required|string',
            'customer_token'   => 'required|string',
            'child_id'   => 'required|string',
            'credit_history'   => 'required|string',
            'behaviour'   => 'required|string',
            'participation'   => 'required|string',
            'daily_instruction'   => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $user_id       = $token->tokenable_id;

        
        $cus_token    = Token::select('tokenable_id','token')->where('token',$request->customer_token)->first();
        $cus_id       = $cus_token->tokenable_id;
        // dd(  $user_id );
        $user = User::where('user_id', '=',   $user_id )->exists();

        if($user){
            $ParentBehaviour  = new ParentBehaviour();
            $ParentBehaviour->user_token  = $request->user_token;
            $ParentBehaviour->provider_id  = $user_id;
            $ParentBehaviour->customer_token  = $request->customer_token;
            $ParentBehaviour->customer_id  = $cus_id;
            $ParentBehaviour->child_id  = $request->child_id;
            $ParentBehaviour->credit_history  = $request->credit_history;
            $ParentBehaviour->behaviour  = $request->behaviour;
            $ParentBehaviour->participation  = $request->participation;
            $ParentBehaviour->daily_instruction  = $request->daily_instruction;
  
            $ParentBehaviour->save();
            if ($ParentBehaviour){
                return response()->json(["status" => "success", "code" => 200, "message" => 'Parent Behaviour  Saved successfully.', 'data' => $ParentBehaviour], 200);
            }
            else{
                return response()->json(["status" => "failure", "code" => 500, "message" => 'Parent Behaviour  not Saved.'], 500);
            }
        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid User Tokken.'], 404);
        }
    }

    public function getAllQuestion(Request $request){

        $data  = Question::with('provider_answers','provider_answers.provider_details')->get();

        if($data){
           
            if(count($data) > 0){
                return response()->json(["status" => "success", "code" => 200, "message" => 'All Question Fetched successfully.', 'data' => $data], 200);
            }
            else
            {
                return response()->json(["status" => "failure", "code" => 404, "message" => 'No Question Found.'], 404);
            }

        }
        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'No Question Found.'], 404);
        }

    }

    public function reportCus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'  => 'required|string',
            'customer_id'    => 'required',
            'report_reason' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $cus_token    = Token::select('tokenable_id','token')->where('token',$request->user_token)->first();
        $cus_id       = $cus_token->tokenable_id;
        // dd(  $user_id );
        $user = User::where('user_id', '=',   $cus_id )->exists();

        if($user){
            $report                = new ReportCus();
            $report->user_token    = $request->user_token;
            $report->customer_id      = $request->customer_id;
            $report->report_reason   = $request->report_reason;
            $report->save();

            if ($report){
                return response()->json(["status" => "success", "code" => 200, "message" => 'Report Submitted successfully.'], 200);
            }
            else{
                return response()->json(["status" => "failure", "code" => 500, "message" => 'Report not Submitted.'], 500);
            }

        }

        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid User Tokken.'], 404);
        }
     
    }

    public function reportcount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failure", "code" => 201, "message" => 'Validation errors ', 'errors' => $validator->errors()->all()], 201);
        }

        $customer_id      = $request->customer_id;

        $user = User::where('user_id', '=',$customer_id)->exists();

        if($user){

            $user = ReportCus::where('customer_id', '=',$customer_id)->get();

            $report_count = count($user);

            if(count($user) > 0)
            {
                return response()->json(["status" => "success", "code" => 200, 'report_count' => $report_count], 200);
            }

            else
            {
                return response()->json(["status" => "failure", "code" => 404, "message" => 'No reports Found.'], 404);
            }
        }

        else
        {
            return response()->json(["status" => "failure", "code" => 404, "message" => 'Invalid User ID.'], 404);
        }
     
    }

    public function download(Request $request){

       $files = Download::get();
       $base_path = url('')."/public/download_report/";
       return response()->json(["status" => "success", "code" => 200, 'base_path' => $base_path, 'files' => $files], 200);

    }
    

    

}
     