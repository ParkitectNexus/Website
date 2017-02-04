<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\CreateSocialUser;
use PN\Users\User;

class CreateSocialUserTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCreateSocialUserGoogle()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;

        \UserRepo::shouldReceive("add");
        \UserRepo::shouldReceive("edit");

        //act
        $user = $this->dispatch(new CreateSocialUser("some_name", "fake@email.com", "http://image?sz=50", "1245152v1234", "google"));

        //assert
        $this->assertTrue($user->username == '');
        $this->assertTrue($user->email == 'fake@email.com');
        $this->assertTrue($user->avatar == 'http://image?sz=128');
        $this->assertTrue($user->social_id == '1245152v1234');
        $this->assertTrue($user->social_name == 'google');
    }

    public function testCreateSocialUserFacebook()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;

        \UserRepo::shouldReceive("add");
        \UserRepo::shouldReceive("edit");

        //act
        $user = $this->dispatch(new CreateSocialUser("some_name", "fake@email.com", "http://image?type=large", "1245152v1234", "facebook"));

        //assert
        $this->assertTrue($user->username == '');
        $this->assertTrue($user->email == 'fake@email.com');
        $this->assertTrue($user->avatar == 'http://image?type=large');
        $this->assertTrue($user->social_id == '1245152v1234');
        $this->assertTrue($user->social_name == 'facebook');
    }

    public function testCreateSocialUserEmptyEmail()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;

        \UserRepo::shouldReceive("add");
        \UserRepo::shouldReceive("edit");

        //act
        $user = $this->dispatch(new CreateSocialUser("some_name", "1245152v1234@google.com", "http://image?sz=50", "1245152v1234", "google"));

        //assert
        $this->assertTrue($user->username == '');
        $this->assertTrue($user->email == '1245152v1234@google.com');
        $this->assertTrue($user->avatar == 'http://image?sz=128');
        $this->assertTrue($user->social_id == '1245152v1234');
        $this->assertTrue($user->social_name == 'google');
    }
}
