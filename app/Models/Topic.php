<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Topic extends Model
{   
    protected $fillable = ['title', 'description'];

    /**
     * Speech relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }

    /**
     * Follower relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function followers()
    {
        return $this->morphToMany(User::class, 'followerble', 'followerbles', 'followerble_id', 'follower_id');
    }
}
