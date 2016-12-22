<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\ChangePassword;
use PN\Users\User;

class ChangePasswordTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testChangePassword()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';

        $userData = [
            'user' => $user,
            'password' => '123456'
        ];
        \UserRepo::shouldReceive("edit")->once()->with(\Mockery::type(User::class));

        //act
        $this->dispatch(app(ChangePassword::class, $userData));

        //assert
        $this->assertTrue(\Hash::check('123456', $user->password));
        $this->assertTrue($user->username == 'Nice_username');

    }
}
