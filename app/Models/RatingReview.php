<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RatingReview extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table ='tbl_rating_review';

    public function customer_details()
    {
        return $this->BelongsTo('App\Models\User', 'user_id', 'user_id');
    }
    
    public function provider_details()
    {
        return $this->BelongsTo('App\Models\User', 'provider_id', 'user_id');
    }
    
}
