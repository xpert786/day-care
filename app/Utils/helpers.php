<?php
use App\Models\User;                             
use Illuminate\Support\Facades\{Log};
function send_push_notification($provider_id,$check_id)
{
    if($check_id==1){
        $title = 'New Booking Request Arrived';
        $body = 'click to view request and confirm';
    }
    elseif($check_id==2){
        $title = 'Booking Accepted';
        $body = 'greetings your booking is accepted';
    }
    elseif($check_id==3){
        $title = 'Booking Rejected';
        $body = 'alas! your booking is rejected';
    }
    elseif($check_id==4){
        $title = 'Booking Completed';
        $body = 'your booking is completed';
    }

    $user_fcm_token = User::select('fcm_tokken')->where('user_id',$provider_id)->first();
    $fcm_token = $user_fcm_token->fcm_tokken;
    // dd(  $fcm_token);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
         "to": '.json_encode($fcm_token).',
     "notification":{
        "title":  '. $title.',
        "body": '. $body.',
      },
      "priority": "high",
      "badge":1
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: key=AAAAXCogmq0:APA91bGSrWKT1VWFFy0pJQrhcTbkJHaS9IyJiaKT6pYjSDPY_10_jgkHn7WxgFmvzMfQbIIrc6gFSThN-foIIt16pMgtDoGgKrU-kJpfyfOLr-g6t1zXm45iBcdzD0-F8nJamszEQVh9',
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
      Log::Info($response);
	return 1; 
}

?>           