<?php

namespace Vandarpay\InternalWebhook\Providers;

use Illuminate\Support\ServiceProvider;

class InternalWebhookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/webhooks.php', 'webhooks');
    }

    public function boot(): void
    {

    }
}
