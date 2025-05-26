<?php

namespace App\Events\FsWatch;

class FileCreated extends FsWatchEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(string $filePath)
    {
        parent::__construct($filePath);
    }
}
