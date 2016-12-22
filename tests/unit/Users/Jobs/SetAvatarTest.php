<?php


use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Users\Jobs\SetAvatar;
use PN\Users\User;
use Helper\StorageMockTrait;

class SetAvatarTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    use StorageMockTrait;
    /**
     * @var \UnitTester
     */
    protected $tester;
    public function testSetAvatar()
    {
        //arrange
        $this->tester->disableEvents();

        $storage = $this->mockStorage();
        $storage->shouldReceive("put")
            ->with(\Mockery::on(function ($arg) {
                $this->image_source = $arg;
                return true;
            }), \Mockery::any())
            ->once();
        \Storage::shouldReceive('disk')
            ->with('avatars')
            ->once()
            ->andReturn($storage);

        $user = \Mockery::mock(User::class)->makePartial();
        $user->username = 'Nice_username';
        $user->password = '5555';
        $user->confirmed = 0;
        $user->shouldReceive("setAvatar")
            ->with("nawenfa9wnefasndfnawienfkd");

        $userData = [
            'user' => $user,
            'rawImage' => file_get_contents(base_path('tests/_data/files/blueprint.png'))
        ];
        \UserRepo::shouldReceive("edit")->once()->with(\Mockery::on(function ($arg) {
            return true;
        }));

        //act
        $this->dispatch(app(SetAvatar::class, $userData));

        //assert
        $this->assertTrue($user->avatar == $this->image_source);

    }
}
