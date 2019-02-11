<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    protected $fillable = [
            'user_id', 'team_id',
    ];

    public function user ()
    {
        return $this->belongsTo('App\User', 'oauth_id', 'user_id');
    }

    public function team ()
    {
        return $this->belongsTo('App\Team', 'team_id', 'slack_team_id');
    }

    public function scopeUserId ($query, $user_id = null)
    {
        $id = $user_id ?: \Auth::user()->oauth_id;
        return $query->where('user_id', $id);
    }

    public function scopeTeamId ($query, $team_id = null)
    {
        $id = $team_id ?: \App\Slack::usersInfo()->team_id;
        return $query->where('team_id', $id);
    }

    public static function firstOrCreateTeamUser ($user, $team)
    {
        $params = ['user_id' => $user->oauth_id, 'team_id' => $team->slack_team_id];
        $team_user = self::firstOrCreate($params);
        return $team_user;
    }
}
