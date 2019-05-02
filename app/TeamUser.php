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
        'user_id', 'team_id', 'slack_access',
    ];

    public function user ()         { return $this->belongsTo('App\User', 'user_id', 'id'); }
    public function team ()         { return $this->belongsTo('App\Team', 'team_id', 'id'); }
    public function subTeamUsers () { return $this->hasMany('App\SubTeamUser', 'team_user_id', 'id'); }
     public function emotions ()    { return $this->hasMany('App\Emotion', 'team_user_id', 'id'); }

    public function scopeTeamId ($query, $id) { return $query->where(['team_id' => $id]); }
    public function scopeUserId ($query, $id) { return $query->where(['user_id' => $id]); }
    public function scopeMe($query)           { return $query->userId(\Auth::user()->id); }


    public static function findByTeamId ($team_id)
    {
        return self::teamId($team_id)->userId()->first();
    }
}
