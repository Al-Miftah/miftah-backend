<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

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
            'speaker_avatar' => $this->speaker->avatar,
            'speech_date' => $this->speech->created_at,
            'message' => "{$this->speaker->last_name} {$this->speaker->last_name}: {$this->speech->title}",
            'label' => 'new-speech-available'
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
