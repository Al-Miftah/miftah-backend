<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{   
    protected $fillable = ['title', 'description'];

    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }

     /**
      * Return users following this topic
      */
    public function followers()
    {
        return $this->morphToMany(User::class, 'followerble', 'followerbles', 'followerble_id', 'follower_id');
    }
}
