<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'name', 'oauth_token', 'oauth_id', 'sns', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            'password', 'remember_token',
    ];

    public static function slack ()
    {
        return new \App\Slack();
    }

    public function teamUsers ()
    {
        return $this->hasMany('App\TeamUser', 'oauth_id', 'oauth_id');
    }
}
