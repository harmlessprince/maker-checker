<?php

namespace App\Notifications;

use App\Models\Approval;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestSubmittedNotification extends Notification
{
    use Queueable;

    public Approval $approval;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hi, ' . $notifiable->first_name . ' ' . $notifiable->last_name)
            ->line('This is to notify you that an approval request has been submitted')
            ->line('Request type: ' . $this->approval->operation)
            ->line('Submitted by: ' . $this->approval->createdBy->first_name . ' ' . $this->approval->createdBy->last_name)
            ->line('Submitted: ' . $this->approval->created_at->diffForHumans())
            ->action('View Request', route('requests.show', $this->approval))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
