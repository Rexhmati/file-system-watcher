<?php

namespace App\Services;
use App\Contracts\FileHandlerInterface;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class JpgOptimizerService implements FileHandlerInterface
{
    public function handle(string $path): void
    {
        $manager = new ImageManager(new Driver());

        // compress the JPEG image, 75% quality
        $manager->read($path)
            ->toJpeg(75)
            ->save($path);
    }
}
