<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailData;

    /**
     * Create a new message instance.
     *
     * @param $mailData
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject($this->mailData['mail_title'])
            ->view('emails.mail')
            ->with([
                'title' => $this->mailData['mail_title'],
                'mail_text' => $this->mailData['mail_body']
            ]);
    }
}
