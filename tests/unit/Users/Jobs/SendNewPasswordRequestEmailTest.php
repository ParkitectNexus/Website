<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\SendNewPasswordRequestEmail;
use PN\Users\User;

class SendNewPasswordRequestEmailTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSendNewPasswordRequestEmail()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->email = 'fake@email.com';
        $user->name = 'test';
        $user->confirmed = 0;

        \Mail::fake();

        //act
        $this->dispatch(new SendNewPasswordRequestEmail($user));

        //assert
        \Mail::assertSent(\PN\Users\Mail\NewPasswordMail::class);
    }


}
