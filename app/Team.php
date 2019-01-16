<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function getSlackTeams ()
    {
        return $this->slackTeamId()->get();
    }

    public function scopeSlackTeamId ($query)
    {
        $slack_team_id = \Auth::user()->usersInfo()->team_id;
        return $query->where('slack_team_id', $slack_team_id);
    }
}
