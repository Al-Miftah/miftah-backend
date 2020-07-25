<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Question extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'user_id'];

    /**
     * Answers relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Favorites relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }
}
