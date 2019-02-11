<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamUser extends Model
{
    use \App\Traits\Findable;

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
        'user_id', 'team_id',
    ];

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id', 'slack_user_id');
    }

    public function team ()
    {
        return $this->belongsTo('App\Team', 'team_id', 'slack_team_id');
    }

    public function scopeUserId ($query, $user_id = null)
    {
        $id = $user_id ?: \Auth::user()->slack_user_id;
        return $query->where('user_id', $id);
    }

    public function scopeTeamId ($query, $team_id = null)
    {
        $id = $team_id ?: \App\Slack::usersInfo()->team_id;
        return $query->where('team_id', $id);
    }

    public static function firstOrCreateTeamUser ($user, $team)
    {
        $params    = ['user_id' => $user->slack_user_id, 'team_id' => $team->slack_team_id];
        $team_user = self::firstOrCreate($params);
        return $team_user;
    }

    public static function findByTeamId ($team_id)
    {
        return self::findBy([
            'user_id' => \Auth::user()->slack_user_id,
            'team_id' => \App\Team::find($team_id)->slack_team_id,
        ]);
    }

}
