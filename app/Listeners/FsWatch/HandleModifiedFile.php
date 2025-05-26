<?php

namespace App\Listeners\FsWatch;

use App\Events\FsWatch\FileModified;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleModifiedFile implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(FileModified $event): void
    {
        // TODO:: Implement logic to handle the modified file event.
    }
}
