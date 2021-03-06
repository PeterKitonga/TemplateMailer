<?php

namespace App\Console\Commands;

use App\Jobs\GetRecipients;
use App\MailSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Log;

class SendMail extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends schedule mail templates to attached recipients';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();

        $schedules = MailSchedule::query()
            ->where('schedule_date', 'like', '%'.$now->format('Y-m-d').'%')
            ->where('schedule_time', 'like', '%'.$now->format('H:i').'%')
            ->with('mailTemplate', 'mailRecipients')
            ->get();

        Log::info($schedules->toArray());

        if (count($schedules) > 0)
        {
            foreach ($schedules->toArray() as $schedule)
            {
                $this->dispatch(new GetRecipients($schedule));
            }
        }

        return $this->info('Mail successfully sent to recipients');
    }
}
