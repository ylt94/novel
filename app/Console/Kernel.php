<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \App\Console\Commands\NovelBase::class,
        \App\Console\Commands\NovelDetail::class,
        \App\Console\Commands\NovelContent::class,
        \App\Console\Commands\NovelNew::class,
        \App\Console\Commands\NovelContentOne::class,
        \App\Console\Commands\NovelContentTwo::class,
        \App\Console\Commands\NovelContentThree::class,
        \App\Console\Commands\NovelContentFour::class,
        \App\Console\Commands\NovelContentFive::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command('NovelBase')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
