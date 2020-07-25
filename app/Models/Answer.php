<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Answer extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'speaker_id', 'question_id'];

    /**
     * Question relation
     *
     * @return mixed
     */
    public function question()
    {
        return $this->belongsTo(Qeustion::class);
    }

    /**
     * Answerer relation
     *
     * @return mixed
     */
    public function answerer()
    {
        return $this->belongsTo(Speaker::class, 'speaker_id');
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }
}
