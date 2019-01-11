<?php
if (! function_exists('to_query')) {
    function to_query($params)
    {
        return urlencode(json_encode(array_filter($params)));
    }
}