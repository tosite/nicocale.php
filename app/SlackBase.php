<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

abstract class SlackBase extends Model
{
    protected $client = '';
    protected $token = '';
    protected $base_url = 'https://slack.com/api';

    public function __construct($slack_token, array $attributes = [])
    {
        parent::__construct($attributes);
        $this->client = new Client;
        $this->token = $slack_token;
    }

    protected function httpGet($action, $param = '')
    {
        $url = "{$this->base_url}/{$action}?token={$this->token}{$param}";
        $res = $this->client->get($url);
        $data = json_decode($res->getBody(), true);
        if ($data["ok"] === false) throw new \Exception(json_encode($data));
        return $data;
    }

    protected function httpPost($action, $param = '')
    {
        $url = "{$this->base_url}/{$action}?token={$this->token}{$param}";
        $res = $this->client->post($url);
        $data = json_decode($res->getBody(), true);
        if ($data["ok"] === false) throw new \Exception(json_encode($data));
        return $data;
    }

    protected function to_query($params)
    {
        return urlencode(json_encode(array_filter($params)));
    }
}
