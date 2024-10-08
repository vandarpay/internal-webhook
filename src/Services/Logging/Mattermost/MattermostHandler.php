<?php

namespace Vandarpay\InternalWebhook\Services\Logging\Mattermost;

use App\Jobs\WebhookJob;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

class MattermostHandler extends AbstractProcessingHandler
{
    public function __construct(private readonly string $baseUrl, private readonly string $token, $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    protected function write(LogRecord $record): void
    {
        $record['formatted'] = $this->getDefaultFormatter()->format($record);
        WebhookJob::dispatch('post', "$this->baseUrl/$this->token", ['text' => $record['formatted']]);
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new MattermostFormatter();
    }
}
