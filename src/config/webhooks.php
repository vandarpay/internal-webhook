<?php

return [
    'queue_name' => 'internal-webhooks',
    'exception_class' => \App\Exceptions\ExternalServiceException::class,
    'mattermost' => [
        'base_url' => env('MATTERMOST_BASE_URL'),
        'stage_base_url' => env('MATTERMOST_STAGE_BASE_URL'),
        'channels' => [
            'local' => '',
            'stage' => '',
        ],
    ],
];
