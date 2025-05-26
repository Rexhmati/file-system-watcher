<?php

namespace App\Listeners\FsWatch;

use App\Contracts\FileHandlerInterface;
use App\Events\FsWatch\FileCreated;
use App\Services\JpgOptimizerService;
use App\Services\JsonForwarderService;
use App\Services\TxtAppenderService;
use App\Services\ZipExtractorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class HandleCreatedFile implements ShouldQueue
{

    /**
     * @var array|string[] $handlers
     */
    protected array $handlers;

    public function __construct()
    {
        $this->handlers = config('fswatcher.handlers', []);
    }

    /**
     * Handle the event.
     */
    public function handle(FileCreated $event): void
    {
        try {
            $path = $event->filePath;
            Log::channel('fswatcher')->info("------------------------------ HandleCreatedFile: $path ------------------------------");

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (!$ext) {
                Log::channel('fswatcher')->warning("HandleCreatedFile: No extension found for file: $path");
            }

            Log::channel('fswatcher')->info("HandleCreatedFile: Detected $ext file: $path");

            if (isset($this->handlers[$ext])) {
                /** @var FileHandlerInterface $service */
                $service = app($this->handlers[$ext]);
                $service->handle($path);
            } else {
                Log::channel('fswatcher')->info('No action for created file type: ' . $ext);
            }
        } catch (\Exception $e) {
            Log::channel('fswatcher')->error('Error handling created file: ' . $e->getMessage());
            throw $e; // Re-throw to ensure the job fails
        }
    }
}
