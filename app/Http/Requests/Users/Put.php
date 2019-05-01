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
            'bio' => 'string',
            'emoji_set' => [
                'string',
                Rule::in(['apple', 'google', 'twitter', 'emojione', 'messenger', 'facebook']),
            ],
        ];
    }

    public function attributes()
    {
        return [
            'bio' => '自己紹介',
            'emoji_set' => 'Emojiスキン',
        ];
    }
}
