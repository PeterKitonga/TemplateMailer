<?php

namespace App\Jobs;

use App\Mail\SendTemplateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class SendMailTemplate implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $template;
    protected $recipient;

    /**
     * Create a new job instance.
     *
     * @param $template
     * @param $recipient
     */
    public function __construct($template, $recipient)
    {
        $this->template = $template;
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filePath = storage_path('templates/').mt_rand(1000000, 9999999).'.pdf';

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(str_replace('{{name}}',$this->recipient['mail_recipient_name'], $this->template['mail_attachment_content']))
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save($filePath);

        $email = new SendTemplateMail($this->recipient, $this->template, $filePath);

        Mail::to($this->recipient['mail_recipient_email'])->send($email);

        File::delete($filePath);
    }
}
