<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * Return speeches the user favorited
     */
    public function favorites()
    {
        return $this->belongsToMany(Speech::class, 'favorites', 'user_id', 'speech_id')
                    ->withTimeStamps();
    }

    /**
     * Questions asked by the user
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Return items the user follows. Speaker or Topic
     */
    public function following()
    {
        //
    }
}
