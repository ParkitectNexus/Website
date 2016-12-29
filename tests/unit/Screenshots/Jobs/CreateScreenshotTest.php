<?php

//class CreateScreenshotTest extends \Codeception\Test\Unit
//{
//    use StorageMockTrait;
//    /**
//     * @var \UnitTester
//     */
//    protected $tester;
//
//    public function testCreateScreenshot()
//    {
//        //arrange
//        $user = \Mockery::mock(User::class)->makePartial();
//        $user->username = 'Nice_username';
//        $user->name = 'Even nicer name';
//        $user->email = 'info@email.com';
//        $user->password = '123456';
//        $user->password_token = 'token';
//        $user->api_key = "some_key";
//        $user->id = 1234;
//
//        \ImageRepo::shouldReceive("add")->with(\Mockery::on(function ($arg) {
//            $arg->id = 1041;
//            return true;
//        }))->once();
//        \UserRepo::shouldReceive("findByApiKey")->with("some_key")->once()->andReturn($user);
//
//        $storage = $this->mockStorage();
//        $storage->shouldReceive("put")->with(\Mockery::type("string"), \Mockery::any())->once();
//        \Storage::shouldReceive('disk')->with('images')->andReturn($storage);
//
//        \ScreenshotRepo::shouldReceive("add")->with(\Mockery::on(function ($arg) {
//            $this->assertTrue($arg->user_id == 1234);
//            $this->assertTrue($arg->image_id == 1041);
//            $this->assertTrue($arg->title == "Nice screenie mate");
//            return true;
//        }))->once();
//
//        //act
//        $this->call('POST', 'api/screenshot/create', [
//            'title' => 'Nice screenie mate'
//        ], [], [
//            'screenshot' => new UploadedFile(base_path('tests/files/image.jpg'), 'image.jpg')
//        ], [
//            'HTTP_Authorization' => $user->api_key
//        ]);
//
//        //assert
//    }
//}