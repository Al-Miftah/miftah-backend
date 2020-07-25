<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Speech extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['title', 'summary', 'transcription', 'url', 'cover_photo', 'speaker_id', 'topic_id'];

    /**
     * Tag relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    
    /**
     * Speaker relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    /**
     * Topic relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Favorite relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }
}
