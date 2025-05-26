<?php

namespace App\Services;

use App\Contracts\FileHandlerInterface;
use Illuminate\Support\Facades\Http;

class JsonForwarderService implements FileHandlerInterface
{
    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = config('fswatcher.json_forwarder_endpoint', 'https://example.com/api/forward-json');
    }

    public function handle(string $path): void
    {
        if (!file_exists($path)) return;

        $json = file_get_contents($path);

        Http::timeout(5)->post($this->endpoint, [
            'filename' => basename($path),
            'content' => $json,
        ]);
    }
}
