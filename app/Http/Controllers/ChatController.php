<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Service;
use App\Models\Visit;
use App\Models\Scheduletime;
use App\Models\Notification;
use App\Models\Chat;
use Auth;
class ChatController extends Controller
{
     public function getChat(Request $request){

        $id=$request->id;

        $notification=Notification::where('id',$id)->first();

        $noti=Notification::all();


        $sender=Chat::where('notification_id',$id)->get();


        $chat=Chat::where('notification_id',$id)->first();

        $sender_id=$chat->sender_id;

        $receiver_id=$chat->received_id;


        return view('admin.chat.chat')->with('notification',$notification)->with('noti',$noti)->with('sender',$sender)->with('sender_id',$sender_id)->with('id',$id);
    }
    
        public function postchat(Request $request)
       {

        $id=$request->id;
        $message=$request->message;
        $user=Auth::user();
        $sender_id=$user->id;
        $received_id=$request->received_id;
        $notification_id=$request->id;

        // echo $notification_id;die;


         $oldchat=Chat::where('notification_id',$notification_id)->first();

         if ($oldchat!='') {
           $receiver_id=$oldchat->receiver_id;

            $chat=new Chat();

        $chat->message=$message;
        $chat->sender_id=$sender_id;
        $chat->received_id=$received_id;
        $chat->notification_id=$notification_id;


        $chat->save();

        return redirect('admin/chat/chat/'.$id);
         }
         else{

            $notification=Notification::where('id',$notification_id)->first();

             $receiver_id=$request->receiver_id;

              $chat=new Chat();

        $chat->message=$message;
         $chat->sender_id=$sender_id;
          $chat->received_id=$received_id;
        $chat->notification_id=$notification_id;


        $chat->save();

        return redirect('admin/chat/chat/'.$id);

         }


         

       
    }
}
