<?php  

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Topic;


class TopicObserver
{
    public function saving(Topic $topic)
    {
        $topic->slug = Str::slug($topic->title);
    }
}
