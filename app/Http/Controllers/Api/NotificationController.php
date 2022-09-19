<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Interfaces\NotificationInterface;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(NotificationInterface $notificationInterface){
        $this->notificationInterface = $notificationInterface;
    }
    public function notificationList(){
        return $this->notificationInterface->notificationList();
    }
    public function updateNotification($id){
        return $this->notificationInterface->updateNotification($id);
    }
}
