<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailSend = $this->view('emails.site-email')
                    ->from($this->data['from'])
                    ->replyTo($this->data['reply_to'])
                    ->subject($this->data['subject'] ?? 'Mail From Canably')
                    ->to($this->data['to'])
                    ->with($this->data);
        if(isset($this->data['attachment'])){
            $mailSend = $mailSend->attachData($this->data['attachment'], $this->data['attachmentFileName']);
        }
        return $mailSend;
    }
}
