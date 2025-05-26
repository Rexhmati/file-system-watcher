<?php

namespace App\Console\Commands;

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
    public function handle()
    {
        $this->info("Watching directory: {$this->watchDir}");
    }
}
