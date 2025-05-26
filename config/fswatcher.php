<?php

/**
 * File System Watcher Configuration
 */

return [
    'directory' => storage_path(env('FSWATCHER_DIRECTORY', 'app/watch')),
    'json_forwarder_endpoint' => env('FSWATCHER_JSON_FORWARDER_ENDPOINT', 'https://fswatcher.requestcatcher.com/'),
    'bacon_api' => env('FSWATCHER_BACON_API', 'https://baconipsum.com/api/?type=meat-and-filler'),
    'meme_api' => env('FSWATCHER_MEME_API', 'https://meme-api.com/gimme'),

    'handlers' => [
        'jpg'  => App\Services\JpgOptimizerService::class,
        'jpeg' => App\Services\JpgOptimizerService::class,
        'json' => App\Services\JsonForwarderService::class,
        'txt'  => App\Services\TxtAppenderService::class,
        'zip'  => App\Services\ZipExtractorService::class,
    ],
];
