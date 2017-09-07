<?php

namespace App\Mail;

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
    protected $mailData;
    protected $filePath;

    /**
     * Create a new message instance.
     *
     * @param $recipient
     * @param $mailData
     * @param $filePath
     */
    public function __construct($recipient, $mailData, $filePath)
    {
        $this->recipient = $recipient;
        $this->mailData = $mailData;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->mailData['mail_has_attachment'] == 1)
        {
            $mail = $this->from(env('MAIL_FROM_ADDRESS'))
                ->subject($this->mailData['mail_subject'])
                ->view('emails.mail')
                ->with([
                    'subject' => $this->mailData['mail_subject'],
                    'title' => str_replace('{{name}}', $this->recipient['mail_recipient_name'], $this->mailData['mail_title']),
                    'body' => str_replace('{{company}}', $this->recipient['mail_recipient_company_name'], $this->mailData['mail_body_content'])
                ])
                ->attach($this->filePath, ['as' => $this->mailData['mail_attachment_name'].'.pdf', 'mime' => 'application/pdf']);
        } else {
            $mail = $this->from(env('MAIL_FROM_ADDRESS'))
                ->subject($this->mailData['mail_subject'])
                ->view('emails.mail')
                ->with([
                    'subject' => $this->mailData['mail_subject'],
                    'title' => str_replace('{{name}}',$this->recipient['mail_recipient_name'], $this->mailData['mail_title']),
                    'body' => str_replace('{{company}}',$this->recipient['mail_recipient_company_name'], $this->mailData['mail_body_content'])
                ]);
        }

        return $mail;
    }
}
