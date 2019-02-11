<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    // プライマリキー
    protected $primaryKey   = 'slack_user_id';
    protected $keyType      = 'string';
    public    $incrementing = false;

    // コンストラクタを追加
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['id'] = Str::orderedUuid();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'name', 'slack_token', 'slack_user_id', 'sns', 'avatar',
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
        return $this->hasMany('App\TeamUser', 'slack_user_id', 'slack_user_id');
    }
}
