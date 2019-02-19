<?php

namespace App\Traits;

trait ModelVaidatable
{
    protected function rules ()
    {
        return [];
    }

    public function save ($options = [])
    {
        $rules = $this->rules();
        if(!empty($rules)) \Validator::validate($this->attributes, $rules);
        parent::save($options);
    }

}
