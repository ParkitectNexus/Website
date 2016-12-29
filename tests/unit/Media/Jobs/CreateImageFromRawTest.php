<?php

use Helper\StorageMockTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Media\Image;
use PN\Media\Jobs\CreateImageFromRaw;

class CreateImageFromRawTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    use StorageMockTrait;

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testImageRaw()
    {

        //arrange
        $storage = $this->mockStorage();
        $storage->shouldReceive("put")->with(\Mockery::on(function ($arg) {
            $this->image_source = $arg;
            return true;
        }), \Mockery::any())->once();
        \Storage::shouldReceive('disk')->with('images')->once()->andReturn($storage);
        \ImageRepo::shouldReceive('add')->with(\Mockery::type(Image::class))->once();

        $raw = file_get_contents(base_path('tests/_data/files/blueprint.png'));

        //act
        $image = $this->dispatch(app(CreateImageFromRaw::class, [$raw]));

        //assert
        $this->assertInstanceOf(Image::class, $image);
        $this->assertTrue($image->source == $this->image_source);
    }
}