<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    public function user ()
    {
        return $this->belongsTo('App\User', 'oauth_id', 'oauth_id');
    }

    public function team ()
    {
        return $this->belongsTo('App\Team', 'team_id', 'id');
    }

    public function scopeSlackTeamId ($query)
    {
        dd($this->slack_team_id);
//        return $query->where('slack_team_id', $slack_team_id);
    }

    public function scopeJoinedTeams ($query)
    {
        $id = \App\Slack::usersInfo()->team_id;
        return $query->where('slack_team_id', $id);
    }
}
