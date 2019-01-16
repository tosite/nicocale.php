<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function teamUsers ()
    {
        return $this->hasMany('App\TeamUser', 'slack_team_id', 'slack_team_id');
    }
}
