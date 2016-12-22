<?php


use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\SetUsername;
use PN\Users\Repositories\UserRepositoryInterface;
use PN\Users\User;

class SetUsernameTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testUsername()
    {
        //arrange
        $this->tester->disableEvents();

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;
        $user->notification_rate = "old_notification_rate";
        $user->recap_rate = "old_recap_rate";

        $userRepository = \Mockery::mock(UserRepositoryInterface::class);
        $userRepository->shouldReceive("find")->with(1083)->andReturn($user);

        $userData = [
            'userId' => 1083,
            'username' => 'asdfasdf',
            'userRepo' => $userRepository
        ];
        \UserRepo::shouldReceive("edit")->once();

        //act
        $user = $this->dispatch(app(SetUsername::class, $userData));

        //assert
        $this->assertTrue($user->username == 'asdfasdf');
    }
}
