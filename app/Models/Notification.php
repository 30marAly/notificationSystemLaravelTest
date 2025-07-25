<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    use HasFactory;

    protected $fillable = ['title', 'description', 'notification_type' ,'recipient', 'is_sent', 'is_cancelled' , 'isRead','scheduled_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
