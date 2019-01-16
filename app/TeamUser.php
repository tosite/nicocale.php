<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    protected $fillable = [
            'oauth_id', 'slack_team_id', 'team_id',
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
