<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubTeam extends Model
{
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
        'name', 'avatar', 'team_id',
    ];

    public function team ()         { return $this->belongsTo('App\Team', 'team_id', 'id'); }
    public function subTeamUsers () { return $this->hasMany('App\SubTeamUser', 'sub_team_id', 'id'); }

    public function scopeTeamId ($query, $teamId) { return $query->where(['team_id' => $teamId]); }

    public static function notJoined ($subTeamId, $teamUserId) {
        $notJoinedSubTeamId = self::leftjoin('sub_team_users', 'sub_teams.id', '=', 'sub_team_users.sub_team_id')
            ->where(['sub_teams.id' => $subTeamId, 'sub_team_users.team_user_id' => $teamUserId])
            ->whereNull('sub_team_users.id')
            ->get('sub_teams.id')
            ->toArray()
        ;
        return self::whereIn(['id' => $notJoinedSubTeamId])->get()->toArray();
    }
}
