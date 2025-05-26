<?php

namespace App\Console\Commands;

use App\Events\FsWatch\FileCreated;
use App\Events\FsWatch\FileDeleted;
use App\Events\FsWatch\FileModified;
use App\Models\FileSnapshot;
use Illuminate\Console\Command;

class WatchFileSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:watch-file-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watch the file system for changes and trigger actions accordingly';

    /**
     * The directory to watch.
     *
     * @var string $watchDir
     */
    protected string $watchDir;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->watchDir = config('fswatcher.directory');
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("Starting file system watcher...");

        $this->scan();
    }

    public function scan(): void
    {
        try {

            if (!is_dir($this->watchDir)) {
                throw new \Exception('Directory does not exist: ' . $this->watchDir);
            }

            $this->info("Scanning directory: {$this->watchDir}");

            // Get current files in the directory
            $currentMap = collect(scandir($this->watchDir))
                ->reject(fn($file) => in_array($file, ['.', '..']))
                ->mapWithKeys(function ($file) {
                    $path = $this->watchDir . '/' . $file;
                    return is_file($path) ? [$path => filemtime($path)] : [];
                });

            // Get existing snapshots from the database
            $snapshots = FileSnapshot::all()->keyBy('path');

            $this->info("Found " . $currentMap->count() . " files in the directory.");
            foreach ($snapshots as $path => $snapshot) {
                if (!isset($currentMap[$path])) {
                    event(new FileDeleted($path));
                    $snapshot->delete();
                    $this->warn("Deleted: $path");
                } elseif ($snapshot->last_modified !== $currentMap[$path]) {
                    $snapshot->update(['last_modified' => $currentMap[$path]]);
                    event(new FileModified($path));
                    $this->info("Modified: $path");
                }

                $currentMap->forget($path);
            }

            foreach ($currentMap as $path => $mtime) {
                FileSnapshot::create([
                    'path' => $path,
                    'last_modified' => $mtime,
                ]);
                event(new FileCreated($path));
                $this->info("Created: $path");
            }

        } catch (\Exception $e) {
            $this->error("Error scanning directory: {$e->getMessage()}");
            return;
        }

    }
}
