<?php

namespace App\Services;

use App\Contracts\FileHandlerInterface;
use ZipArchive;

class ZipExtractorService implements FileHandlerInterface
{

    public function handle(string $path): void
    {
        if (!file_exists($path)) return;

        $zip = new ZipArchive;
        $status = $zip->open($path);

        if ($status === true) {
            $zip->extractTo(dirname($path));
            $zip->close();
        }
    }
}
