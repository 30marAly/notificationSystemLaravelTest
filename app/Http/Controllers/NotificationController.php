<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;

class NotificationController extends Controller
{
    //
    public function index(){
        $notifications = Notification::latest()->get();
        return view('notifications.index',compact('notifications'));
    }

    public function create()
    {
        return view('notifications.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'notification_type' => 'required|in:mail,sms,push',
            'recipient' => 'required|string',
            'scheduled_at' => 'nullable|date',
            //'is_sent'=> 'required|in:true,false',
        ]);

            // ✅ تحويل التوقيت
        $scheduledAt = $request->scheduled_at
         ? \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->scheduled_at, 'Africa/Cairo')->setTimezone('UTC')
        : null;

        $notification = Notification::create([
            'title' => $request->title,
            'description' => $request->description,
            'notification_type' => $request->notification_type,
            'recipient' => $request->recipient,
            'scheduled_at' => $scheduledAt,
            //'is_sent' => $request->is_sent == 'true' ? true : false, 
        ]);

        // $notification = Notification::update([
        //     'is_cancelled' => true, 
        // ]);

        if (!$notification) {
            return back()->with('error', '❌ Saving notification failed.');
        }

        return redirect()->route('notifications.index')->with('success', 'Notification scheduled successfully.');

    }

    public function updateCancelledStatus(Request $request, $id)
    {

        $notification = Notification::findOrFail($id); 
        $notification->is_cancelled = !$notification->is_cancelled; 
        $notification->save();

        return redirect()->route('notifications.index');
    }

}

