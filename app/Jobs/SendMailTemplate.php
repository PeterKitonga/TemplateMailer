<?php

namespace App\Jobs;

use App\Mail\SendTemplateMail;
use App\MailLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpWord\TemplateProcessor;

class SendMailTemplate implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $template;
    protected $recipient;
    protected $scheduleId;

    /**
     * Create a new job instance.
     *
     * @param $template
     * @param $recipient
     * @param $scheduleId
     */
    public function __construct($template, $recipient, $scheduleId)
    {
        $this->template = $template;
        $this->recipient = $recipient;
        $this->scheduleId = $scheduleId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $number = mt_rand(1000000, 9999999);
        $pdfFile = storage_path('templates/').$number.'.pdf';
        $wordFile = storage_path('templates/').$number.'.docx';
        $variables = array_pluck(json_decode($this->template['mail_attachment_file_variables']), 'tag');

        if ($this->template['mail_has_attachment_file'] == 1)
        {
            $templateProcessor = new TemplateProcessor($this->template['mail_attachment_file_url']);
            $templateProcessor->setValue($variables, array($this->recipient['mail_recipient_name'], $this->recipient['mail_recipient_company_name'], $this->recipient['mail_recipient_company_position'], Carbon::today()->format('jS F Y')));
            $templateProcessor->saveAs($wordFile);

            shell_exec(env('LIBREOFFICE_DIR').' --headless --convert-to pdf '.$wordFile.' --outdir '.storage_path('templates'));
        } else {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML(str_replace('{{name}}',$this->recipient['mail_recipient_name'], $this->template['mail_attachment_content']))
                ->setPaper('a4', 'landscape')
                ->setWarnings(false)
                ->save($pdfFile);
        }

        try {
            $email = new SendTemplateMail($this->recipient, $this->template, $pdfFile, $this->scheduleId);

            Mail::to($this->recipient['mail_recipient_email'])->send($email);

            MailLog::create([
                'mail_recipient_email' => $this->recipient['mail_recipient_email'],
                'status' => 'Sent',
                'user_id' => $this->template['user_id'],
                'mail_template_id' => $this->template['id'],
                'mail_schedule_id' => $this->scheduleId
            ]);

        } catch (\Exception $exception) {
            MailLog::create([
                'mail_recipient_email' => $this->recipient['mail_recipient_email'],
                'status' => 'Failed',
                'user_id' => $this->template['user_id'],
                'mail_template_id' => $this->template['id'],
                'mail_schedule_id' => $this->scheduleId
            ]);
        }

        File::delete($pdfFile, $wordFile);
    }
}
