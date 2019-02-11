<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamUser extends Model
{
    // プライマリーキーの型
    protected $keyType = 'string';

    // プライマリーキーは自動連番か？
    public $incrementing = false;

    // コンストラクタを追加
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['id'] = Str::orderedUuid();
    }

    protected $fillable = [
            'oauth_id', 'team_id',
    ];

    public function user ()
    {
        return $this->belongsTo('App\User', 'oauth_id', 'oauth_id');
    }

    public function team ()
    {
        return $this->belongsTo('App\Team', 'team_id', 'id');
    }

    public function scopeOauthId ($query, $oauth_id = null)
    {
        $id = $oauth_id ?: \Auth::user()->oauth_id;
        return $query->where('oauth_id', $id);
    }

    public function scopeSlackTeamId ($query, $slack_team_id = null)
    {
        $id = $slack_team_id ?: \App\Slack::usersInfo()->team_id;
        return $query->where('slack_team_id', $id);
    }
}
