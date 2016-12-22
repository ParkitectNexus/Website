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

        $userData = [
            'user' => $user,
        ];

        \Mail::shouldReceive("send")->once()->with("auth.emails.new-password", \Mockery::on(function ($arg) {
            $this->assertArrayHasKey('user', $arg);
            return true;

        }), \Mockery::on(function (\Closure $closure) {
            $mock = \Mockery::mock('Illuminate\Mailer\Message');
            $mock->shouldReceive('from')->once()->with('info@parkitectnexus.com', 'ParkitectNexus')->andReturn($mock);
            $mock->shouldReceive('to')->once()->with("fake@email.com", "test")->andReturn($mock);
            $mock->shouldReceive('subject')->with(\Mockery::any())->andReturn($mock);

            $closure($mock);

            return true;
        }));

        //act
        $this->dispatch(app(SendNewPasswordRequestEmail::class, $userData));

        //assert
    }


}
