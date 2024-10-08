<?php

namespace Vandarpay\InternalWebhook\Services;

use Vandarpay\InternalWebhook\Services\Logging\Mattermost\MattermostHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class Webhook
{
    private string $baseUrl;

    private string $token;

    public function __construct()
    {
        $this->baseUrl = (config('app.env') != 'stage') ? config('webhooks.mattermost.base_url') : config('webhooks.mattermost.stage_base_url');
    }

    public function channel(string $channel)
    {
        if (App::isLocal()) {
            $this->token = config('webhooks.mattermost.channels.local');

            return $this;
        }

        if (config('app.env') == 'stage') {
            $this->token = config('webhooks.mattermost.channels.stage');

            return $this;
        }

        $this->token = config('webhooks.mattermost.channels.' . $channel);

        if (!$this->token) {
            throw new InvalidArgumentException('Channel ' . $channel . ' not found in webhooks config');
        }

        return $this;
    }

    public function __call(string $name, array $arguments)
    {
        Log::build([
            'driver' => 'monolog',
            'handler' => MattermostHandler::class,
            'with' => [
                'baseUrl' => $this->baseUrl,
                'token' => $this->token,
            ]
        ])->$name(...$arguments);
    }
}
