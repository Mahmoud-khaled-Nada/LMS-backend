<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use InfyOm\Generator\Commands\API\APIControllerGeneratorCommand;
use InfyOm\Generator\Commands\API\APIGeneratorCommand;
use InfyOm\Generator\Commands\API\APIRequestsGeneratorCommand;
use InfyOm\Generator\Commands\APIScaffoldGeneratorCommand;
use InfyOm\Generator\Commands\RollbackGeneratorCommand;
use InfyOm\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    public function schedule(Schedule $schedule)
    {
        Artisan::call('cache:clear');
        $schedule->command('queue:restart')->everyFiveMinutes();
        $schedule->command('queue:work')->everyMinute()->withoutOverlapping();
        $schedule->command('queue:retry all')->everyTenMinutes();
    }

    protected $commands = [
        ScaffoldGeneratorCommand::class,
        APIGeneratorCommand::class,
        APIRequestsGeneratorCommand::class,
        APIScaffoldGeneratorCommand::class,
        APIControllerGeneratorCommand::class,
        RollbackGeneratorCommand::class,
    ];
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}