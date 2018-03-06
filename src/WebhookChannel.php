<?php
namespace NotificationChannels\Webhook;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use NotificationChannels\Webhook\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class WebhookChannel {
    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification) {
        if ( ! $url = $notifiable->routeNotificationFor('Webhook') ) return;

        $webhookData = $notification->toWebhook($notifiable)->toArray();

        $response = $this->client->post($url, [
            'body' => json_encode(Arr::get($webhookData, 'data')),
            'verify' => false,
            'headers' => Arr::get($webhookData, 'headers'),
        ]);

        if ( $response->getStatusCode() >= 300 || $response->getStatusCode() < 200 ) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
