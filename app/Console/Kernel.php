<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\FulfillGroupUserSparePhones::class,
        Commands\FulfillHxUserAndGroup::class,
        Commands\ClearHxUsersAndGroups::class,
        Commands\MakeDirectorDepartmentEssential::class,
        Commands\RegisterFakeUser::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('fake:register-user')->everyFiveMinutes()->when(function () {
            return date('H') >= 13 && date('H') <= 23;
		})->appendOutputTo(storage_path('logs/register_fake_user.log'));
    }

}
