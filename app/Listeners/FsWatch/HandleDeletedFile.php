<?php

namespace App\Listeners\FsWatch;

use App\Events\FsWatch\FileDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HandleDeletedFile implements ShouldQueue
{
    /**
     * The endpoint for the meme API.
     * @var string
     */
    protected string $memeApiEndpoint;

    public function __construct()
    {
        $this->memeApiEndpoint = config('fswatcher.meme_api', 'https://meme-api.com/gimme');
    }

    /**
     * Handle the event.
     */
    public function handle(FileDeleted $event): void
    {
        try {
            $path = $event->filePath;

            Log::channel('fswatcher')->info("------------------------------ HandleDeletedFile: $path ------------------------------");

            $response = Http::timeout(5)->get($this->memeApiEndpoint);

            if (!$response->ok()) {
                throw new \Exception('Failed to fetch meme from API: ' . $response->status());
            }

            $imageUrl = $response->json('url');
            if (!$imageUrl) {
                throw new \Exception('Failed to fetch image from API: ' . $response->status());
            }

            $image = Http::timeout(10)->get($imageUrl);
            if (!$image->ok()) {
                throw new \Exception('Failed to download meme image: ' . $image->status());
            }

            $dir = dirname($path);
            $basename = pathinfo($path, PATHINFO_FILENAME);
            $newPath = $dir . '/DELETED_' . $basename . '.jpg';

            // Save meme as the same file that was deleted
            file_put_contents($newPath, $image->body());

            Log::channel('fswatcher')->info("HandleDeletedFile: Replaced deleted file} with meme: $newPath");

        } catch (\Exception $e) {
            Log::channel('fswatcher')->error('Error handling deleted file: ' . $e->getMessage());
            throw $e; // Re-throw to ensure the job fails
        }
    }
}
