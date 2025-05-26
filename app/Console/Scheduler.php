<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

class Scheduler
{
    /**
     * @param Schedule $schedule
     * @return void
     */
    public function __invoke(Schedule $schedule): void
    {
        $schedule->command('app:watch-file-system')
            ->everyMinute()
            ->withoutOverlapping();
    }
}
