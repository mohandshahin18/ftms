<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppliedNotification extends Notification
{
    use Queueable;

    protected $name;
    protected $image;
    protected $reason;
    protected $category;
    protected $student_id;
    protected $category_id;
    protected $company_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name , $image , $reason ,$category ,$student_id ,$category_id ,$company_id  )
    {
        $this->name = $name;
        $this->image = $image;
        $this->reason = $reason;
        $this->category = $category;
        $this->student_id = $student_id;
        $this->category_id = $category_id;
        $this->company_id = $company_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return ['database'];
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
            'msg' => 'Applied to your company',
            'image' => $this->image ,
            'reason' => $this->reason,
            'category' => $this->category,
            'url' => url('/admin/read-notify'),
            'student_id' => $this->student_id,
            'category_id' => $this->category_id,
            'company_id' => $this->company_id,

        ];
    }
}
