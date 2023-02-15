<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptApplyNotification extends Notification
{
    use Queueable;

    protected $name;
    protected $slug;
    protected $company_id;
    protected $categoryName;
    protected $studentName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name ,$slug,$company_id ,$categoryName ,$studentName )
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->company_id = $company_id;
        $this->categoryName = $categoryName;
        $this->studentName = $studentName;

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
            'company_id' => $this->company_id ,
            'from' => 'apply',
            'msg' => 'Accepted Youre request to their company',
            'url' => url('/company/'.$this->slug.'/'.$this->categoryName ),
            'welcome' => ' Hi '. $this->studentName . ' Welcome to join to our company',

        ];
    }
}
