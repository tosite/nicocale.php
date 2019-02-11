<?php

namespace App\Traits;

trait Findable
{
    public function scopeFindBy($query, $params)
    {
        foreach ($params as $key => $param)
        {
            $query->where([$key => $param]);
        }
        return $query->first();
    }
}
