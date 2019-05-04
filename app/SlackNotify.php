<?php

namespace App;


class SlackNotify extends SlackBase
{
    protected $channel;
    protected $text;
    protected $attachments;
    protected $emoji = ':smile:';

    public function channel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    public function text($text)
    {
        $this->text = $text;
        return $this;
    }

    // ref: https://qiita.com/daikiojm/items/759ea40c00f9b539a4c8
    public function attachments($attachments)
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function emoji($emoji)
    {
        $this->emoji = $emoji;
        return $this;
    }

    public function send()
    {
        $params = [
            'channel' => $this->channel,
            'icon_emoji' => $this->emoji,
            'text' => $this->text,
        ];

        if (!empty($this->attachments)) {
            $params['attachments'] = json_encode([$this->attachments]);
            $params['text'] = '';
        }

        $query = $this->to_raw_query($params);
        $res = $this->httpPost('chat.postMessage', $query);
        return $res;
    }
}
