<?php

namespace App\Events\FsWatch;

class FileModified extends FsWatchEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(string $filePath)
    {
        parent::__construct($filePath);
    }
}
