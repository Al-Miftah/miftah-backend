<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'speaker_id', 'question_id'];

    public function question()
    {
        return $this->belongsTo(Qeustion::class);
    }

    public function answerer()
    {
        return $this->belongsTo(Speaker::class, 'speaker_id');
    }
}
