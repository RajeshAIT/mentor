<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;


use App\Models\User;

class SendPushNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $fcmTokens;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title,$message,$fcmTokens)
    {
        $this->title = $title;
        $this->message = $message;
        $this->fcmTokens = $fcmTokens;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFirebase($notifiable)
    {

        $FcmToken = User::whereNotNull('fcm')->pluck('fcm')->all();

        $deviceTokens = [
            '{faTrhRr6ENkq9VG7e3haly:APA91bHTkVeqTiSiHSA1Rm-q5JIThuMcPghY9R6E7zImLMgvyfT0T1XinF9kjbhkyn2cofmtA0tTiWawc9XXBh6qKFQjpV9j3rjUGDCB8JQeeO72oHP6SPvh5JcpkwLOonRzHjdwI7Uy}'
        ];

        return (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->message)
            ->withPriority('high')->asNotification($deviceTokens);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
