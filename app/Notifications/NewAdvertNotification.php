<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAdvertNotification extends Notification
{
    use Queueable;

    protected $name;
    protected $trainer_id;
    protected $teacher_id;
    protected $company_id;
    protected $from;
    protected $image;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name ,$trainer_id ,$teacher_id ,$company_id, $from,$image )
    {
        $this->name = $name;
        $this->trainer_id = $trainer_id;
        $this->teacher_id = $teacher_id;
        $this->company_id = $company_id;
        $this->from = $from;
        $this->image = $image;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'name' => $this->name ,
            'from' => $this->from,
            'msg' => 'يوجد إعلان جديد',
            'url' => url('/'),
            'image'=> $this->image ,
            'trainer_id' => $this->trainer_id ,
            'teacher_id' => $this->teacher_id ,
            'company_id' => $this->company_id ,

        ];
    }
}
