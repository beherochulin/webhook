<?php
namespace NotificationChannels\Webhook;

class WebhookMessage {
    protected $data;
    protected $headers;
    protected $userAgent;

    public static function create($data = '') {
        return new static($data);
    }

    public function __construct($data = '') {
        $this->data = $data;
    }
    public function data($data) {
        $this->data = $data;
        return $this;
    }
    public function header($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }
    public function userAgent($userAgent) {
        $this->headers['User-Agent'] = $userAgent;
        return $this;
    }
    public function toArray() {
        return [
            'data' => $this->data,
            'headers' => $this->headers,
        ];
    }
}
