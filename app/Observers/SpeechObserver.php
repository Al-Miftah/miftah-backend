<?php  

namespace App\Observers;

use App\Models\Speech;
use Illuminate\Support\Str;


class SpeechObserver
{
    public function saving(Speech $speech)
    {
        $speech->slug = Str::slug($speech->title);
    }
}
