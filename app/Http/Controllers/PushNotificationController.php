<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\ApiService;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\SendPushNotification;
use App\Models\User;
use App\Models\UserNotification;
use Kutia\Larafirebase\Facades\Larafirebase;

class PushNotificationController extends Controller
{

    public $apiService;

    public $validationService;

    public function __construct()
    {
        $this->apiService = new ApiService();
        $this->validationService = new ValidationService();
    }

    public function updateToken(Request $request){
        try{
            $user = auth('sanctum')->user()->update(['fcm_token'=> $request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function notification(Request $request){
        $request->validate([
            'title'=>'required',
            'message'=>'required'
        ]);
        try{
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            if($request->recv_id){
                $fcmTokens = User::where('uuid', $request->recv_id)->first()->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                // $fcmTokens = $request->recv_id;
            }
            if ($request->receiver_id === 'admin') {
                $adminUUID = Role::where('role', 'admin')->pluck('uuid')->first();
                if ($adminUUID) {
                    $fcmTokens = User::where('role_uuid', $adminUUID)
                        ->whereNotNull('fcm_token')
                        ->pluck('fcm_token')
                        ->toArray();
                }
            }
            // Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));
            $this->addNotification($request->sender_id, $request->receiver_id, $request->message, $request->type, isset($request->order_id) ? $request->order_id : null);
            /* or */
    
            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));
    
            /* or */
    
            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);
    
                return response()->json([
                    'success'=>true
                ]);
    
        }catch(\Exception $e){
            dd($e);
            return response()->json([
                'success'=>false
            ]);
        }
    }
    public function addNotification($senderId, $receiverId, $message, $type, $orderId)
    {
        $notification = new UserNotification();
        $notification->sender_id = $senderId;
        if($orderId){
            $notification->order_id = $orderId;
        }
        if($senderId != null){
            $notification->sender_id = $senderId;
        } else {
            $clients = User::whereHas('role', function ($query) {
                $query->where('role', 'Admin');
            })->first();
            $notification->sender_id = $clients->uuid;
        }
        if($receiverId != null && $receiverId !== 'admin'){
            $notification->receiver_id = $receiverId;
        } else {
            $clients = User::whereHas('role', function ($query) {
                $query->where('role', 'Admin');
            })->first();
            $notification->receiver_id = $clients->uuid;
        }
        $notification->message = $message;
        $notification->type = $type;
        $notification->save();
    
        return $notification;
    }

}

