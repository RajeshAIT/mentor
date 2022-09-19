<?php 

namespace App\Interfaces;

interface NotificationInterface
{
    
    public function notificationList();

    public function updateNotification($id);
}