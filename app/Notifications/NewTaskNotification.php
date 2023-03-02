<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTaskNotification extends Notification implements ShouldQueue
{

    use Queueable;

    protected $name;
    protected $slug;
    protected $trainer_id;
    protected $image;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name ,$slug , $trainer_id ,$image )
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->trainer_id = $trainer_id;
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
            'from' => 'task',
            'trainer_id' => $this->trainer_id ,
            'msg' => __('admin.A new task has been assigned to you'),
            'slug'=> $this->slug ,
            'url' => url('/task/'.$this->slug),
            'image'=> $this->image ,


        ];
    }


}
