<?php

namespace PN\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PN\Users\User;

class NewPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("info@parkitectnexus.com", "ParkitectNexus")
            ->subject("New password request")
            ->view("auth.emails.new-password")
            ->with([
                "user" => $this->user
            ]);
    }
}
