<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
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

    public function slack ()
    {
        return new \App\Slack($this->slack_token);
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
