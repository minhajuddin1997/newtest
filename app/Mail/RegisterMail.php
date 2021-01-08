<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email,$password, $link;
    public function __construct($email, $password, $link)
    {
        $this->email=$email;
        $this->password=$password;
        $this->link=$link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //,["email"=>$this->email,"password"=>$this->password]
        return $this->markdown('emails.new_company');
    }
}
