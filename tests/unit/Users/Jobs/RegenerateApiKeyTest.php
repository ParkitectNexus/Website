<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\RegenerateApiKey;
use PN\Users\User;

class RegenerateApiKeyTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;
    public function testRegenerateApiKey()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password_token = "old_token";
        $user->api_key = "old_key";

        $userData = [
            'user' => $user
        ];
        \UserRepo::shouldReceive("edit")->once()->with(\Mockery::type(User::class));

        //act
        $this->dispatch(app(RegenerateApiKey::class, $userData));

        //assert
        $this->assertFalse($user->api_key == "old_key");
    }
}
