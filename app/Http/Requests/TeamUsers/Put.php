<?php

namespace App\Http\Requests\TeamUsers;

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
        return [
            'notify_channel' => 'string|nullable',
            'remind_at'      => ['regex:/^(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/'],
            'skip_holiday'   => 'boolean',
        ];
    }

    public function attributes()
    {
        return [
            'notify_channel' => '通知チャンネル',
            'remind_at'      => 'リマインド',
            'skip_holiday'   => '休日スキップ',
        ];
    }
}
