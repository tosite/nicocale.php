<?php

namespace App\Http\Controllers;

class EmotionController extends Controller
{

    public function store(\App\Http\Requests\Emotions\Post $request)
    {
        $user = \Auth::user();
        $params = array_merge(['user_id' => $user->id], $request->input());
        return response(\App\Emotion::create($params), 201);
    }

    public function update(\App\Http\Requests\Emotions\Put $request, $emotionId)
    {
        $emotion = \App\Emotion::find($emotionId);
        $params = $request->only(['emoji', 'status_text', 'memo']);
        $emotion->fill($params)->save();
        return response($emotion, 200);
    }
}
