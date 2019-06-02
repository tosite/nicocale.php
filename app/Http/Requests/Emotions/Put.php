<?php

namespace App\Http\Requests\Emotions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Put extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $score = collect(\App\Emotion::SCORE)->pluck('value')->toArray();
        return [
            'emoji' => 'required|string',
            'score' => ['required', Rule::in($score)],
            'status_text' => 'string|nullable|max:100',
            'memo' => 'string|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'emoji' => 'Emoji',
            'score' => '気分',
            'status_text' => 'ステータステキスト',
            'memo' => 'メモ',
        ];
    }
}
