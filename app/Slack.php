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
        $this->token  = \Auth::user()->slack_token;
    }

    private function httpGet ($action, $param = '')
    {
        $url  = "{$this->base_url}/{$action}?token={$this->token}{$param}";
        $res  = $this->client->get($url);
        $data = json_decode($res->getBody(), true);
        if ($data["ok"] === false) throw new \Exception('error');
        return json_decode(json_encode($data));
    }

    private function httpPost ($action, $param = '')
    {
        $url  = "{$this->base_url}/{$action}?token={$this->token}{$param}";
        $res  = $this->client->post($url);
        $data = json_decode($res->getBody(), true);
        dd($data);
        if ($data["ok"] === false) throw new \Exception($data['error']);
        return json_decode(json_encode($data));
    }

    public function channelsList ()
    {
        return $this->httpGet('channels.list');
    }

    public static function emojiList ()
    {
        $model = new static();
        return $model->httpGet('emoji.list')->emoji;
    }

    public static function usersList ()
    {
        $model = new static();
        return $model->httpGet('users.list')->members;
    }

    // https://api.slack.com/methods/users.info/test
    public static function usersInfo ($user_id = null)
    {
        $user_id = $user_id ?: \Auth::user()->slack_user_id;
        $model   = new static();
        return $model->httpGet('users.info', "&user={$user_id}")->user;
    }

    // https://api.slack.com/methods/users.profile.set/test
    // {"status_text":"test","status_emoji":":100:","status_expiration":0}
    // profile=%7B%22status_text%22%3A%22test%22%2C%22status_emoji%22%3A%22%3A100%3A%22%7D
    public static function usersProfileSet ($status_text = '', $status_emoji = '')
    {
        $params = [
                'status_text'       => $status_text,
                'status_emoji'      => $status_emoji,
                'status_expiration' => strtotime(date('Y/m/d 23:59:59')),
        ];
        $model = new static();

        if (empty($status_text) && empty($status_emoji)) throw new \Exception('params not exist');
        $query = to_query($params);
        return $model->httpPost('users.profile.set', "&profile={$query}");
    }

    public function test ()
    {
        return $this->httpGet('users.profile.get');
    }

}
