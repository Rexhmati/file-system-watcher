<?php

namespace App\Listeners\FsWatch;

use App\Events\FsWatch\FileModified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class HandleModifiedFile implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(FileModified $event): void
    {
        // In the task documentation, is not specified what to do with modified files.
        // I will log the modification event.
        $path = $event->filePath;
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        Log::channel('fswatcher')->info("------------------------------ File modified: $path (.$ext) ------------------------------");
    }
}
