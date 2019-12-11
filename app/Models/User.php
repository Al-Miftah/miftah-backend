<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\Auth\API\VerifyEmail;
use App\Notifications\Auth\API\ResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @Overriden
     * Custom email verification method for api endpoints
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
    /**
     * @Overriden
     * 
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Return all user favorites
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Questions asked by the user
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Speakers the user follows
     */
    public function speakers()
    {
        return $this->morphedByMany(Speaker::class, 'followerble', 'followerbles', 'follower_id', 'followerble_id');
    }

    /**
     * Topics the user follows
     */
    public function topics()
    {
        return $this->morphedByMany(Topic::class, 'followerble', 'followerbles', 'follower_id', 'followerble_id');
    }
}
