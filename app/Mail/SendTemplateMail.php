<?php

namespace App\Mail;

use App\MailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class SendTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $recipient;
    protected $template;
    protected $filePath;
    protected $scheduleId;

    /**
     * Create a new message instance.
     *
     * @param $recipient
     * @param $template
     * @param $filePath
     * @param $scheduleId
     */
    public function __construct($recipient, $template, $filePath, $scheduleId)
    {
        $this->recipient = $recipient;
        $this->template = $template;
        $this->filePath = $filePath;
        $this->scheduleId = $scheduleId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->template['mail_has_attachment'] == 1)
        {
            $mail = $this->subject($this->template['mail_subject'])->view('emails.mail')
                ->with([
                    'subject' => $this->template['mail_subject'],
                    'title' => str_replace('{{title}}', $this->recipient['mail_recipient_title'], $this->template['mail_title']),
                    'body' => str_replace('{{company}}', $this->recipient['mail_recipient_company_name'], $this->template['mail_body_content'])
                ])
                ->attach($this->filePath, ['as' => $this->template['mail_attachment_name'].'.pdf', 'mime' => 'application/pdf']);
        } else {
            $mail = $this->subject($this->template['mail_subject'])->view('emails.mail')
                ->with([
                    'subject' => $this->template['mail_subject'],
                    'title' => str_replace('{{title}}',$this->recipient['mail_recipient_title'], $this->template['mail_title']),
                    'body' => str_replace('{{company}}',$this->recipient['mail_recipient_company_name'], $this->template['mail_body_content'])
                ]);
        }

        return $mail;
    }
}
