<?php

namespace App\Console;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
                    $trips = DB::table('trips')->selectRaw("driver_id,count(id) as trips_count_per_month")
                            ->where(DB::raw('MONTH(trip_date)'), '>=', date('n'))
                            ->groupBy('driver_id')
                            ->get()->toArray();
                    DB::table('users')->update(['trips_count_per_month' => 0]);
                    foreach ($trips as $trip) {
                        DB::table('users')->where('id', $trip->driver_id)->update(['trips_count_per_month' => $trip->trips_count_per_month]);
                    }
                })->everyMinute()
                ->evenInMaintenanceMode();

        $schedule->call(function () {
                    $trips = DB::table('trips')->selectRaw("driver_id,count(id) as trips_count_per_year")
                    ->where(DB::raw('YEAR(trip_date)'), '>=', new Carbon('-1 year'))
                    ->groupBy('driver_id')->get()->toArray();
                    DB::table('users')->update(['trips_count_per_year' => 0]);
                    foreach ($trips as $trip) {
                        DB::table('users')->where('id', $trip->driver_id)->update(['trips_count_per_year' => $trip->trips_count_per_year]);
                    }
                })->everyMinute()
                ->evenInMaintenanceMode();
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
