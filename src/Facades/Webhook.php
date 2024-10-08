<?php

namespace Vandarpay\InternalWebhook\Facades;

use Illuminate\Support\Facades\Facade;
use Psr\Log\LoggerInterface;

/**
 * @method static void emergency(string $message, array $context = [])
 * @method static void alert(string $message, array $context = [])
 * @method static void critical(string $message, array $context = [])
 * @method static void error(string $message, array $context = [])
 * @method static void warning(string $message, array $context = [])
 * @method static void notice(string $message, array $context = [])
 * @method static void info(string $message, array $context = [])
 * @method static void debug(string $message, array $context = [])
 * @method static void log($level, string $message, array $context = [])
 * @method static self channel(string $channel)
 * @method static LoggerInterface stack(array $channels, string $channel = null)
 */
class Webhook extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Vandarpay\InternalWebhook\Services\Webhook::class;
    }
}
