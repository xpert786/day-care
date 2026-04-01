<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    public function chatsender(){
		return $this->belongsTo('App\Models\User','sender_id','id');
	}

    public function profile()
    {
    	return $this->belongsTo('App\Models\User','received_id','user_id');
    }
    
}
