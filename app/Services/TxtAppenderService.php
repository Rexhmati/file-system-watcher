<?php

namespace App\Services;

use App\Contracts\FileHandlerInterface;
use Illuminate\Support\Facades\Http;

class TxtAppenderService implements FileHandlerInterface
{
    protected string $baconApi;

    public function __construct()
    {
        $this->baconApi = config('fswatcher.bacon_api', 'https://baconipsum.com/api/?type=meat-and-filler');
    }

    public function handle(string $path): void
    {
        if (!file_exists($path)) return;

        $response = Http::timeout(5)->get($this->baconApi);

        if ($response->ok()) {
            $bacon = implode("\n", $response->json());
            file_put_contents($path, "\n\n" . $bacon, FILE_APPEND);
        }
    }
}
