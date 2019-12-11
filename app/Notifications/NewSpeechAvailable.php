<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSpeechAvailable extends Notification implements ShouldQueue
{
    use Queueable;

    protected $speech;
    protected $speaker;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($speech, $speaker)
    {
        $this->speech = $speech;
        $this->speaker = $speaker;
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
                    ->line('New .')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'speech' => $this->speech->toArray(),
            'speaker' => $this->speaker->toArray(),
            'message' => "{$this->speaker->last_name} {$this->speaker->last_name}: {$this->speech->title}"
        ];
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
