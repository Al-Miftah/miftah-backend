<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'user_id'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Person asking the question
     */
    public function asker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
