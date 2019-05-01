<?php

namespace App\Http\Requests\Users;

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
            ''
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
