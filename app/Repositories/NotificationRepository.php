<?php

namespace App\Repositories;

use File;

use App\Models\User;
use App\Models\Notification;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\NotificationInterface;
use Illuminate\Support\Facades\Validator;

class NotificationRepository implements NotificationInterface
{
  
    public function notificationList(){

      $notification_list = Notification::where("user_id",Auth::user()->id)->orderBy('created_at','DESC')->get();
      
      $unseen     = Notification::where([["user_id",Auth::user()->id],["seen","0"]])->get();
      $seen       = Notification::where([["user_id",Auth::user()->id],["seen","1"]])->get();
      $unseen_cnt = count($unseen);
      $seen_cnt   = count($seen);

      $responseData["status"]  = true;
      $responseData["message"] = "Notification retrived Successfully";
      $responseData["seen"] = $seen_cnt;
      $responseData["unseen"] = $unseen_cnt;
      $responseData["data"]["notification_list"]    = $notification_list;
        
      return response()->json($responseData);
    }

    public function updateNotification($id){

      $notification_list = Notification::where([["id",$id],["seen","0"]])->first();

      if($notification_list){
        $update_det = Notification::where([["id",$id],["user_id",Auth::user()->id]])
                                    ->update(["seen" => "1" ]);

        if($update_det){
          $responseData["status"]  = true;
          $responseData["message"] = "Notification Seen Successfully";
        }else{
          $responseData["status"]  = true;
          $responseData["message"] = "Invalid User Cannot Updated";
        }
      }else{
        $responseData["status"]  = false;
        $responseData["message"] = "Notification Cannot Updated";
      }
      
        
      return response()->json($responseData);
    }
}