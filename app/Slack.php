<?php

namespace App;


class Slack extends SlackBase
{
    public static function oauthAccess($code) {
        $instance = new self;
        $params = [
            'client_id' => env('SLACK_KEY'),
            'client_secret' => env('SLACK_SECRET'),
            'code' => $code,
        ];
        $query = $instance->to_raw_query($params);
        $url = "{$instance->base_url}/oauth.access?{$query}";
        $res = $instance->client->get($url);
        $data = json_decode($res->getBody(), true);
        if ($data["ok"] === false) throw new \Exception(json_encode($data));
        return (object) $data;
    }

    public function channelsList()
    {
        $res = $this->httpGet('channels.list');
        return $res['channels']; // [0 => [...]]
    }

    public function emojiList()
    {
        $res = $this->httpGet('emoji.list');
        return $res['emoji']; // ['name' => 'png']
    }

//    public function usersIdentity()
//    {
//        $res = $this->httpGet('users.identity');
//        return (object)$res['user'];
//    }

    public function teamInfo()
    {
        $res = $this->httpGet('team.info');
        return (object)$res['team'];
    }

    public function usersInfo($userId)
    {
        $res = $this->httpGet('users.info', "&user={$userId}");
        return (object)$res['user'];
    }

    public function chatPostMessage($channel, $text, $emoji = ':smile:')
    {
        $params = [
            'channel' => $channel,
            'text' => $text,
            'icon_emoji' => $emoji,
        ];

        $query = $this->to_raw_query($params);
        $res = $this->httpPost('chat.postMessage', $query);
        return $res;
    }

    // https://api.slack.com/methods/users.profile.set/test
    // {"status_text":"test","status_emoji":":100:","status_expiration":0}
    // profile=%7B%22status_text%22%3A%22test%22%2C%22status_emoji%22%3A%22%3A100%3A%22%7D
    public function usersProfileSet($status_text = '', $status_emoji = '')
    {
        $params = [
            'status_text' => $status_text,
            'status_emoji' => $status_emoji,
            'status_expiration' => strtotime(date('Y/m/d 23:59:59')),
        ];

        if (empty($status_text) && empty($status_emoji)) throw new \Exception('params not exist');
        $query = $this->to_query($params);
        return $this->httpPost('users.profile.set', "&profile={$query}");
    }

}
