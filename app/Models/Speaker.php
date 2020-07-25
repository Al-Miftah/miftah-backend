<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Speaker extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;
    
    protected $guard = 'speaker';

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'phone_number', 'bio', 'city', 'location_address', 'avatar'];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Speeches relation
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

    /**
     * Question relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
