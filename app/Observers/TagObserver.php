<?php  

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Str;


class TagObserver
{
    public function saving(Tag $tag)
    {
        $tag->slug = Str::slug($tag->name);
    }
}
