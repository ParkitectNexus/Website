<?php

use Helper\StorageMockTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Media\Image;
use PN\Media\Jobs\ResizeImage;

class ResizeImageTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    use StorageMockTrait;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSetImageOnAsset()
    {
        //arrange
        $this->tester->disableEvents();

        $storage = $this->mockStorage();
        $storage->shouldReceive("put")->with(\Mockery::type("string"),
            \Mockery::type("string"))->times(count(config('images.sizes')));

        \Storage::shouldReceive('disk')->with('images')->andReturn($storage);

        $raw = file_get_contents(base_path('tests/_data/files/blueprint.png'));
        $image = \Mockery::mock(Image::class)->makePartial();
        $image->shouldReceive("getRaw")->andReturn($raw);

        //act
        $this->dispatch(app(ResizeImage::class, [$image]));

        //assert
    }
}
