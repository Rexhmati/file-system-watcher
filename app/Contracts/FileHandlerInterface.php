<?php

namespace App\Contracts;

interface FileHandlerInterface
{
    /**
     * Handle the file at the given path.
     */
    public function handle(string $path): void;
}
