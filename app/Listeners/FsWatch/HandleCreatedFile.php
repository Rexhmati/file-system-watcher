<?php

namespace App\Listeners\FsWatch;

use App\Events\FsWatch\FileCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class HandleCreatedFile implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(FileCreated $event): void
    {
        // TODO:: Implement logic to handle the created file event.
    }
}
