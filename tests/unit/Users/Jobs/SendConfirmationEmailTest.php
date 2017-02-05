<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Mail\Message;
use PN\Foundation\Presenters\Presenter;
use PN\Users\Jobs\SendConfirmEmail;
use PN\Users\User;

class SendConfirmationEmailTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSendConfirmationEmailConfirmed()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->email = 'fake@email.com';
        $user->confirmed = 0;

        $presenter = new Presenter("User");
        $presenter->displayName = "test";
        $user->shouldReceive("getPresenter")->andReturn($presenter);

        \Mail::fake();

        //act
        $this->dispatch(new SendConfirmEmail($user));

        //assert
        \Mail::assertSent(\PN\Users\Mail\ConfirmUserMail::class);
    }

    public function testSendConfirmationEmailUnConfirmed()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->email = 'fake@email.com';
        $user->confirmed = 1;

        $presenter = new Presenter("User");
        $presenter->displayName = "test";
        $user->shouldReceive("getPresenter")->andReturn($presenter);

        \Mail::fake();

        //act
        $this->dispatch(new SendConfirmEmail($user));

        //assert
        \Mail::assertNotSent(\PN\Users\Mail\ConfirmUserMail::class);
    }
}
