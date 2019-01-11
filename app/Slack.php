<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Slack extends Model
{
    protected $client   = '';
    protected $token    = '';
    protected $base_url = 'https://slack.com/api';

    public function __construct (array $attributes = [])
    {
        parent::__construct($attributes);
        $this->client = new Client;
        $this->token  = \Auth::user()->oauth_token;
    }

    private function httpGet ($action)
    {
        $url = "{$this->base_url}/{$action}?token={$this->token}";
        $res = $this->client->get($url);
        return json_decode($res->getBody(), true);
    }

    private function getUrlString ($paramsAsJson)
    {
        $json = json_encode($paramsAsJson);
        return urlencode($json);
    }

    private function httpPost ($action, $params)
    {
        $url = "{$this->base_url}/{$action}?token={$this->token}&$params";
        $res = $this->client->post($url);
        return json_decode($res->getBody(), true);

    }

    public function channelsList ()
    {
        return $this->httpGet('channels.list');
    }

    public function emojiList ()
    {
        return $this->httpGet('emoji.list');
    }

    public function usersList ()
    {
        return $this->httpGet('users.list');
    }

    public function usersProfileSet ($status_text = '', $status_emoji = '')
    {
        $params = [];
        if (empty($status_text) && empty($status_emoji)) return ['ok' => false, 'error' => 'params not exist'];

        if (!empty($status_text)) $params['status_text'] = $status_text;
        if (!empty($status_emoji)) $params['status_emoji'] = $status_emoji;

        $query = $this->getUrlString($params);
        return $this->httpPost('users.profile.set', "profile={$query}");
    }

    public function test ()
    {
        return $this->httpGet('users.profile.get');
    }

}
