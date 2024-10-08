<?php

namespace Vandarpay\InternalWebhook\Services\Logging\Mattermost;

use Monolog\Formatter\FormatterInterface;
use Monolog\Level;
use Monolog\LogRecord;

class MattermostFormatter implements FormatterInterface
{
    public function __invoke($logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new self());
        }
    }

    protected function getTable(LogRecord $record): string
    {
        if (!$record['context']) {
            return '';
        }

        $table = "| Key | Value |\n|:---|:---|\n";
        foreach ($record['context'] as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
            $key = ucfirst($key);
            $table .= "| $key | $value |\n";
        }
        return $table;
    }

    protected function getEmoji(LogRecord $record): string
    {
        return $record->level >= Level::Error ? ':x: ' : '';
    }

    public function format(LogRecord $record): string
    {
        return $this->getEmoji($record) . $record['message'] . "\n\n" . $this->getTable($record);
    }

    public function formatBatch(array $records): string
    {
        $formatted = '';
        foreach ($records as $record) {
            $formatted .= $this->format($record) . "\n";
        }

        return $formatted;
    }
}
