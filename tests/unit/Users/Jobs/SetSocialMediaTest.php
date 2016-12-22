<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\SetSocialMedia;
use PN\Users\User;

class SetSocialMediaTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSocialMediaMethod()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;
        $user->notification_rate = "old_notification_rate";
        $user->recap_rate = "old_recap_rate";

        $userData = [
            'user' => $user,
            'twitter' => 'asdfnaiwenfawnef',
            'twitch' => 'awsefawienfawrecapRate'
        ];
        \UserRepo::shouldReceive("edit")->once()->with(\Mockery::type(User::class));

        //act
        $this->dispatch(app(SetSocialMedia::class, $userData));

        //assert
        $this->assertTrue($user->twitter == 'asdfnaiwenfawnef');
        $this->assertTrue($user->twitch == 'awsefawienfawrecapRate');
    }
}
