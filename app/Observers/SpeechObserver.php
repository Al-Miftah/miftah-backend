<?php  

namespace App\Observers;

use App\Models\Speech;


class SpeechObserver
{
    public function creating(Speech $speech)
    {
        $speech->slug = str_slug($speech->title);
    }

    public function updating(Speech $speech)
    {
        $speech->slug = str_slug($speech->title);
    }
}
