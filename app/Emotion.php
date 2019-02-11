<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Emotion extends Model
{
    use \App\Traits\Findable;
    use \App\Traits\Datable;
    use \App\Traits\ModelVaidatable;

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

    protected function rules ()
    {
        return [
            'emoji'       => 'required|max:1',
            'status_text' => 'max:100',
            'entered_on'  => 'required|date',
        ];
    }

    public function team ()     { return $this->belongsTo('App\Team',     'team_id','id'); }
    public function user ()     { return $this->belongsTo('App\User',     'user_id','id'); }
    public function teamUser () { return $this->belongsTo('App\TeamUser', 'team_user_id','id'); }

    public function scopeTeamId($query, $id)        { return $query->where(['team_id' => $id]); }
    public function scopeUserId($query, $id = null) { return $query->where(['user_id' => $id ?: \Auth::user()->id]); }
    public function scopeTeamUserId($query, $id)    { return $query->where(['team_user_id' => $id]); }

    public static function createOrUpdateEmotion ($keys, $params)
    {
        $emotion = self::firstOrNew($keys);
        $emotion->fill($params);
        $emotion->save();
        return $emotion;
    }

    public static function getBetweenEnteredOn ($team_id, $yyyymm)
    {
        $date_buf = strtotime("{$yyyymm}01");
        $emotions = self::whereBetween('entered_on', [date('Y-m-01', $date_buf), date('Y-m-t', $date_buf)])
            ->where(['team_id' => $team_id])
            ->get();

        return $emotions->keyBy(function ($e) {
            return "{$e->entered_on}-{$e->team_user_id}";
        });
    }
}
