<?php

namespace App\Http\Requests\Emotions;

use Illuminate\Foundation\Http\FormRequest;

class Put extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'emoji' => 'required|string',
            'status_text' => 'string|nullable|max:100',
            'memo' => 'string|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'emoji' => 'Emoji',
            'status_text' => 'ステータステキスト',
            'memo' => 'メモ',
        ];
    }
}
