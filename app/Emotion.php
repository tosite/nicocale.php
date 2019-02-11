<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
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
            'user_id', 'team_id', 'team_user_id', 'emoji',
            'status_text', 'memo', 'entered_on',
    ];

}
