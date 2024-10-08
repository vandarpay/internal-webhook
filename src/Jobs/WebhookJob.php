<?php

namespace Vandarpay\InternalWebhook\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Exception;

class WebhookJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly string $method, private readonly string $url, private readonly array $payload)
    {
        $this->onQueue(config('webhooks.queue_name'));
    }

    public function handle(): void
    {
        $method = $this->method;

        try {
            $response = Http::asJson()->acceptJson()->$method($this->url, $this->payload)->throw();
            if ($response->status() == Response::HTTP_TOO_MANY_REQUESTS) {
                $this->release($response->header('Retry-After', 10 * 60));
            }
        } catch (Exception $exception) {
            $exceptionClass = config('webhooks.exception_class');

            throw new $exceptionClass(baseException: $exception, message: $exception->getMessage());
        }
    }
}
