<?php


use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Assets\Asset;
use PN\Media\Image;
use PN\Media\Jobs\AddImageToAsset;

class AddImageToAssetTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAddImageToAsset()
    {
        //arrange
        $this->tester->disableEvents();

        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->shouldReceive("addImage")->with(\Mockery::type(Image::class))->once();
        $image = \Mockery::mock(Image::class)->makePartial();

        $data = [
            'asset' => $asset,
            'image' => $image
        ];

        //act
        $this->dispatch(app(AddImageToAsset::class, $data));

        //assert
    }
}
