<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens,
    Notifiable;

    // プライマリキー
    protected $keyType      = 'string';
    public    $incrementing = false;

    // コンストラクタを追加
    public function __construct (array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['id'] = Str::orderedUuid();
    }

    protected $fillable = [
        'name', 'slack_token', 'slack_user_id', 'sns', 'avatar', 'bio', 'emoji_set',
    ];

    protected $hidden = [
        'remember_token', 'slack_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function slack ()
    {
        return new \App\Slack($this->slack_token);
    }

    public function slackNotify ()
    {
        return new \App\SlackNotify($this->slack_token);
    }

    public function teamUsers ()
    {
        return $this->hasMany('App\TeamUser', 'user_id', 'id');
    }

    public function emotions ()
    {
        return $this->hasMany('App\Emotion', 'user_id', 'id');
    }
}
