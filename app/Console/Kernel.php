<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Moved schedules from routes/console.php to Kernel
        $schedule->command('app:send-weekly-branch-data-email')
            ->wednesdays()
            ->at('09:00')
            ->timezone('Asia/Jakarta');

        $schedule->command('app:send-stock-email')
            ->everyMinute()
            ->timezone('Asia/Jakarta');

        $schedule->command('app:send-in-unit-email')
            ->dailyAt('09:00')
            ->timezone('Asia/Jakarta');

        $schedule->command('dms:sync-users')
            ->everyTenMinutes()
            ->timezone('Asia/Jakarta');
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        if (file_exists(base_path('routes/console.php'))) {
            require base_path('routes/console.php');
        }
    }
}
