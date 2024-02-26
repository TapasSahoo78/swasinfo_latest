<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
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
        $view_template=$this->data['mail_type'];
               

        $mailSend = $this->view('mail.'.$view_template)
                    ->from($this->data['from'])
                    ->replyTo($this->data['from'])
                    ->subject($this->data['subject'])
                    ->to($this->data['to'])
                    ->with($this->data);

        return $mailSend;
    }
}
