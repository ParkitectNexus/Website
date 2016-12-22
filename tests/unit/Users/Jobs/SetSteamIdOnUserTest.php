<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\SetSteamIdOnUser;
use PN\Users\User;

class SetSteamIdOnUserTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;


    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSteamIdOnUser()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;
        $user->notification_rate = "old_notification_rate";
        $user->recap_rate = "old_recap_rate";
        $user->steam_id = "old_blalba";

        $userData = [
            'user' => $user,
            'steamID' => 'asdfnaiwenfawnef'
        ];
        \UserRepo::shouldReceive("edit")->once()->with(\Mockery::type(User::class));

        //act
        $this->dispatch(app(SetSteamIdOnUser::class, $userData));

        //assert
        $this->assertTrue($user->steam_id == 'asdfnaiwenfawnef');
    }
}
