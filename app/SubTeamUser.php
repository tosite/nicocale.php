<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubTeamUser extends Model
{
    // プライマリキー
    protected $keyType = 'string';
    public $incrementing = false;

    // コンストラクタを追加
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['id'] = Str::orderedUuid();
    }

    protected $fillable = [
        'team_id', 'team_user_id', 'sub_team_id',
    ];

    public function team_user () { return $this->belongsTo('App\TeamUser', 'team_user_id', 'id'); }
    public function sub_team  () { return $this->belongsTo('App\SubTeam', 'sub_team_id', 'id'); }

    public function scopeTeamId     ($query, $team_id)     { return $query->where(['team_id' => $team_id]); }
    public function scopeSubTeamId  ($query, $sub_team_id) { return $query->where(['sub_team_id' => $sub_team_id]); }
    public function scopeTeamUserId ($query, $id = null)   { return $query->where(['team_user_id' => $id ?: \Auth::user()->id]); }

    public static function findOrCreate($team_id, $sub_team_id, $team_user_id) {
        return self::firstOrCreate(['team_id' => $team_id, 'sub_team_id' => $sub_team_id,'team_user_id' => $team_user_id]);
    }
}
