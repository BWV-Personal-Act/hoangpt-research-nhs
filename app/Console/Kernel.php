<?php

namespace App\Console;

use App\Libs\ValueUtil;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    public const LIST_BATCH = [
        'BAT-010',
    ];

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $isBatchSchedule = config('nhs_ihs.batch_schedule');
        if ($isBatchSchedule === true) {
            $schedule->command('batch:BAT-010')->withoutOverlapping()->timezone('Asia/Tokyo')->between('5:30', '21:00')->everyThirtyMinutes();
            $schedule->command('batch:BAT-020')->withoutOverlapping()->timezone('Asia/Tokyo')->between('19:15', '20:00')->everyFifteenMinutes();
            $schedule->command('batch:send-push-notification')
                ->withoutOverlapping()
                ->timezone('Asia/Tokyo')
                ->everyThirtyMinutes();
        }

        // change maintenance mode
        // $modeDown = ValueUtil::constToValue('maintenance.mode.DOWN');
        // $modeUp = ValueUtil::constToValue('maintenance.mode.UP');
        // $schedule->command("batch:change-maintenance-mode {$modeDown} 13時")
        //     ->withoutOverlapping()
        //     ->timezone('Asia/Tokyo')
        //     ->dailyAt('12:30');
        // $schedule->command("batch:change-maintenance-mode {$modeUp}")
        //     ->withoutOverlapping()
        //     ->timezone('Asia/Tokyo')
        //     ->dailyAt('13:00');
        // $schedule->command("batch:change-maintenance-mode {$modeDown} 20時10分")
        //     ->withoutOverlapping()
        //     ->timezone('Asia/Tokyo')
        //     ->dailyAt('19:10');
        // $schedule->command("batch:change-maintenance-mode {$modeUp}")
        //     ->withoutOverlapping()
        //     ->timezone('Asia/Tokyo')
        //     ->dailyAt('20:10');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
