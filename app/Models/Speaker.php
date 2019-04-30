<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speaker extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'phone', 'email', 'bio', 'address', 'avatar'];
    
    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }

    /**
     * Return users following this speaker
     */
    public function followers()
    {
        return $this->morphMany(Follower::class, 'followable');
    }

    /**
     * Questions directed to the speaker
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
