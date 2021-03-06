<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\ConfirmUser;
use PN\Users\User;

class ConfirmUserTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testConfirmUserTest()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;

        \UserRepo::shouldReceive("edit")->once()->with(\Mockery::type(User::class));

        //act
        $this->dispatch(new ConfirmUser($user));

        //assert
        $this->assertTrue($user->confirmed == 1);

    }
}
