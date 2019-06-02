<?php

namespace App\Http\Requests\Emotions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Post extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $score = collect(\App\Emotion::SCORE)->pluck('value')->toArray();
        return [
            'team_id' => 'required|exists:teams,id',
            'team_user_id' => 'required|exists:team_users,id',
            'emoji' => 'required|string',
            'score' => ['required', Rule::in($score)],
            'status_text' => 'string|nullable|max:100',
            'memo' => 'string|nullable',
            'entered_on' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'team_id' => 'チームID',
            'team_user_id' => 'チームユーザーID',
            'emoji' => 'Emoji',
            'score' => '気分',
            'status_text' => 'ステータステキスト',
            'memo' => 'メモ',
            'entered_on' => '日付',
        ];
    }
}
