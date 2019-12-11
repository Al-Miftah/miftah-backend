<?php  

namespace App\Observers;

use App\Models\Speech;
use Illuminate\Support\Str;
use App\Notifications\NewSpeechAvailable;
use Illuminate\Support\Facades\Notification;


class SpeechObserver
{
    public function saving(Speech $speech)
    {
        $speech->slug = Str::slug($speech->title);
    }

    public function created(Speech $speech)
    {
        $speaker = $speech->speaker;
        $followers = $speaker->followers;
        //And send notification to users
        Notification::send($followers, new NewSpeechAvailable($speech, $speaker));
    }
}
