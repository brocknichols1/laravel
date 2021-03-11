<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailTool extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param $data
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
        $email = $this->data['email'] ? $this->data['email'] : 'brock@brocknichols.xyz';
        $from = 'brock@brocknichols.xyz';
        $subject = 'Your Nichols Inc. form was received';
        $name = 'Nichols Inc';
        $body_message = $this->data['message'];
        $user_name = $this->data['name'];

        return $this->view('emails.email')
            ->from($from, $name)
            ->subject($subject)
            ->with([ 
                    'user_name' => $user_name, 
                    'body_message' => $body_message, 
                    'subject' => $subject 
                    ]);
    }


}
