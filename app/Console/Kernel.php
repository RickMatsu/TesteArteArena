<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define os comandos do aplicativo.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define as tarefas agendadas.
     */
    protected function schedule(Schedule $schedule)
    {
        //Agendar um Job diário
        $schedule->job(new \app\Jobs\SyncPostsDaily())->daily();
    }

}
