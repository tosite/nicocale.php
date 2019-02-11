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

    private function httpGet ($action, $param = '')
    {
        $url = "{$this->base_url}/{$action}?token={$this->token}{$param}";
        $res = $this->client->get($url);
        return json_decode($res->getBody(), true);
    }

    private function httpPost ($action, $param = '')
    {
        $url = "{$this->base_url}/{$action}?token={$this->token}{$param}";
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

    public function usersInfo ($user_id)
    {
        // https://api.slack.com/methods/users.info/test
        return $this->httpGet('users.info', "&user={$user_id}");
    }

    public function usersProfileSet ($status_text = '', $status_emoji = '')
    {
        // https://api.slack.com/methods/users.profile.set/test
        // {"status_text":"test","status_emoji":":100:"}
        // profile=%7B%22status_text%22%3A%22test%22%2C%22status_emoji%22%3A%22%3A100%3A%22%7D
        $params = [
                'status_text'       => $status_text,
                'status_emoji'      => $status_emoji,
                'status_expiration' => strtotime(date('Y/m/d 23:59:59')),
        ];

        if (empty($status_text) && empty($status_emoji)) return ['ok' => false, 'error' => 'params not exist'];
        $query = to_query($params);
        return $this->httpPost('users.profile.set', "&profile={$query}");
    }

    public function test ()
    {
        return $this->httpGet('users.profile.get');
    }

}
