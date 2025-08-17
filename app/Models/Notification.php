<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Notification extends Model
{
    //
    use HasFactory;
    

    protected $fillable = ['title', 'description', 'notification_type' ,'recipient', 'is_sent', 'is_cancelled' , 'isRead','scheduled_at' , 'is_removed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

  // protected $model =Carbon::parse($this->scheduled_at)->isPast()? 'disabled' : null;


    //Accessor to check if the notification is passed.
   protected function isPassed() : Attribute
   {
        //Log::error("is_passed");
        return Attribute::make(
            get: fn () => Carbon::parse($this->scheduled_at)->isPast(),
        );
   }
   

}
