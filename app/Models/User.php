<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Auth\API\VerifyEmail;
use App\Notifications\Auth\API\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, HasRoles;

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
     * Favorite relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
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

    /**
     * Speaker relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function speakers()
    {
        return $this->morphedByMany(Speaker::class, 'followerble', 'followerbles', 'follower_id', 'followerble_id');
    }

    /**
     * Topic relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function topics()
    {
        return $this->morphedByMany(Topic::class, 'followerble', 'followerbles', 'follower_id', 'followerble_id');
    }

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
}
