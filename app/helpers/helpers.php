<?php
if (!function_exists('formValue')) {
    function formValue ($key, $model)
    {
        if (empty($model))        return null;
        $model = $model->toArray();
        if (!empty(old($key)))    return old($key);
        if (!empty($model[$key])) return $model[$key];
        return null;
    }
}

if (!function_exists('byKey')) {
    function byKey ($key, $model)
    {
        return isset($model[$key]) ? $model[$key] : null;
    }
}