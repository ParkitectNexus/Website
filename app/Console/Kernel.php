<?php

namespace PN\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use PN\Assets\Console\ResetAllPrimaryTags;
use PN\BuildOffs\Console\RankBuildOffs;
use PN\Foundation\Console\Inspire;
use PN\Social\Console\Commands\RecalculateHotScore;
use PN\Social\Console\Commands\RecalculateLikes;
use PN\Steam\Console\ScrapeWorkshop;
use PN\Tracking\Console\Commands\RecalculateDownloads;
use PN\Tracking\Console\Commands\RecalculateViews;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RecalculateDownloads::class,
        RecalculateViews::class,
        RecalculateLikes::class,
        RecalculateHotScore::class,
        RankBuildOffs::class,
        ResetAllPrimaryTags::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('buildoffs:rank')->hourly();
        $schedule->command('downloads:recalculate')->hourly();
        $schedule->command('views:recalculate')->hourly();
        $schedule->command('likes:recalculate')->everyMinute();
        $schedule->command('score:recalculate')->everyMinute();
    }
}
