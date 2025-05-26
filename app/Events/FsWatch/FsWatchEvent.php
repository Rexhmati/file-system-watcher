<?php

namespace App\Events\FsWatch;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FsWatchEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The path of the file that triggered the event.
     *
     * @var string $filePath;
     */
    public string $filePath;

    /**
     * Create a new event instance.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }
}
