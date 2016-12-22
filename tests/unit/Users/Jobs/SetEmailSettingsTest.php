<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\SetEmailSettings;
use PN\Users\User;

class SetEmailSettingsTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSetEmailSettings()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;
        $user->notification_rate = "old_notification_rate";
        $user->recap_rate = "old_recap_rate";
        $user->shouldReceive("setAvatar")
            ->with("nawenfa9wnefasndfnawienfkd");

        $userData = [
            'user' => $user,
            'notificationRate' => 'notificationRate',
            'recapRate' => 'recapRate'
        ];
        \UserRepo::shouldReceive("edit")
            ->once()
            ->with(\Mockery::type(User::class));

        //act
        $this->dispatch(app(SetEmailSettings::class, $userData));

        //assert
        $this->assertTrue($user->notification_rate == 'notificationRate');
        $this->assertTrue($user->recap_rate == 'recapRate');
    }
}
