<?php

namespace PN\Users\Jobs;


use PN\Jobs\Job;
use PN\Users\Mail\ConfirmUserMail;
use PN\Users\User;

class SendConfirmEmail extends Job
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $user = $this->user;
        
        // only send confirmation mails to non social unconfirmed accounts
        if($user->confirmed == 0) {
            \Mail::to($user->email)->send(new ConfirmUserMail($user));
        }
    }
}
