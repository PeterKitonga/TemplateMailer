<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetRecipients implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, DispatchesJobs;

    protected $schedule;

    /**
     * Create a new job instance.
     *
     * @param $schedule
     */
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template = $this->schedule['mail_template'];
        $recipients = $this->schedule['mail_recipients'];
        $scheduleId = $this->schedule['id'];

        foreach ($recipients as $recipient)
        {
            $this->dispatch(new SendMailTemplate($template, $recipient, $scheduleId));
        }
    }
}
