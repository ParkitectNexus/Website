<?php


namespace PN\Users\Jobs;


use PN\Jobs\Job;
use PN\Users\Mail\NewPasswordMail;
use PN\Users\User;

/**
 * Class SendNewPasswordRequestEmail
 * @package PN\Users\Jobs
 */
class SendNewPasswordRequestEmail extends Job
{
    /**
     * @var User
     */
    private $user;

    /**
     * SendNewPasswordRequestEmail constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $user = $this->user;

        \Mail::to($user->email)->send(new NewPasswordMail($user));
    }
}