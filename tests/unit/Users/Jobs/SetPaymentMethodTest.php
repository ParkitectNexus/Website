<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\SetPaymentMethods;
use PN\Users\User;

class SetPaymentMethodTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;
    public function testSetPaymentMethod()
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
            'paypal' => 'asdfnaiwenfawnef',
            'bitcoin' => 'awsefawienfawrecapRate'
        ];
        \UserRepo::shouldReceive("edit")
            ->once()
            ->with(\Mockery::type(User::class));

        //act
        $this->dispatch(app(SetPaymentMethods::class, $userData));

        //assert
        $this->assertTrue($user->paypal == 'asdfnaiwenfawnef');
        $this->assertTrue($user->bitcoin == 'awsefawienfawrecapRate');
    }
}
