<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speech extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['title', 'summary', 'transcription', 'url', 'cover_photo', 'speaker_id', 'topic_id', 'language_id'];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    
    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Get all speech favorites
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }
}
