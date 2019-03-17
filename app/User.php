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
        'name', 'slack_token', 'slack_user_id', 'sns', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function slack ()
    {
        return new \App\Slack();
    }

    public function teamUsers ()
    {
        return $this->hasMany('App\TeamUser', 'slack_user_id', 'slack_user_id');
    }

    public function emotions ()
    {
        return $this->hasMany('App\Emotion', 'user_id', 'id');
    }
}
