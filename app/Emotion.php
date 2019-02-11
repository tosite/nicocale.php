<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Emotion extends Model
{
    use \App\Traits\Findable;
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

    public static function createEmotion ($keys, $params)
    {
        $emotion = self::firstOrNew($keys);
        $emotion->fill($params);
        $emotion->save();
        return $emotion;
    }
}
