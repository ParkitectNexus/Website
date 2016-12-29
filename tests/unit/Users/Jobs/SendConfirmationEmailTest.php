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

        $userData = [
            'user' => $user,
        ];

        \Mail::shouldReceive("send")->once()->with("auth.emails.confirm", \Mockery::on(function ($arg) {
            $this->assertArrayHasKey('user', $arg);
            return true;

        }), \Mockery::on(function (\Closure $closure) {
            $mock = \Mockery::mock(Message::class);
            $mock->shouldReceive('from')->once()->with('info@parkitectnexus.com', 'ParkitectNexus');
            $mock->shouldReceive('to')->once()->with("fake@email.com", "test")->andReturn($mock);
            $mock->shouldReceive('subject')->with(\Mockery::any());

            $closure($mock);

            return true;
        }));

        //act
        $this->dispatch(app(SendConfirmEmail::class, $userData));

        //assert
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

        $userData = [
            'user' => $user,
        ];

        \Mail::shouldReceive("send")
            ->never()
            ->with("auth.emails.confirm", \Mockery::on(function ($arg) {
                $this->assertArrayHasKey('user', $arg);
                return true;

            }), \Mockery::on(function (\Closure $closure) {
                $mock = \Mockery::mock(Message::class);
                $mock->shouldReceive('from')
                    ->once()
                    ->with('info@parkitectnexus.com', 'ParkitectNexus');
                $mock->shouldReceive('to')
                    ->once()
                    ->with("fake@email.com", "test")->andReturn($mock);
                $mock->shouldReceive('subject')
                    ->with(\Mockery::any());

                $closure($mock);

                return true;
            }));

        //act
        $this->dispatch(app(SendConfirmEmail::class, $userData));

        //assert
    }
}
