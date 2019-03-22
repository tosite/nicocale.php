<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Emotion extends Model
{
    use \App\Traits\Datable;

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
        'user_id', 'team_id', 'team_user_id', 'emoji',
        'status_text', 'memo', 'entered_on',
    ];

    public function team ()     { return $this->belongsTo('App\Team',     'team_id','id'); }
    public function user ()     { return $this->belongsTo('App\User',     'user_id','id'); }
    public function teamUser () { return $this->belongsTo('App\TeamUser', 'team_user_id','id'); }

    public function scopeTeamId($query, $id)        { return $query->where(['team_id' => $id]); }
    public function scopeUserId($query, $id = null) { return $query->where(['user_id' => $id ?: \Auth::user()->id]); }
    public function scopeTeamUserId($query, $id)    { return $query->where('team_user_id', $id); }

    public function scopeBetweenEnteredOn($query, $yyyymm) {
        $date_buf = strtotime("{$yyyymm}01");
        $query->whereBetween('entered_on', [date('Y-m-01', $date_buf), date('Y-m-t', $date_buf)]);
    }

    public static function createOrUpdateEmotion ($keys, $params)
    {
        $emotion = self::firstOrNew($keys);
        $emotion->fill($params);
        $emotion->save();
        // TODO: 移設
        if ($keys['entered_on'] == date('Y-m-d'))
        {
            \App\Slack::usersProfileSet($params['status_text'], $params['emoji']);
        }
        return $emotion;
    }

}
