<?php

namespace App\Listeners\FsWatch;

use App\Events\FsWatch\FileDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleDeletedFile implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(FileDeleted $event): void
    {
        // TODO:: Implement logic to handle the deleted file event.
    }
}
