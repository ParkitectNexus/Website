<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use PN\Assets\Asset;
use PN\Media\Image;
use PN\Media\Jobs\SetImagesOnAsset;

class SetImageOnAssetTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSetImageOnAsset()
    {
        //arrange
        $this->tester->disableEvents();

        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->shouldReceive("setImages")->with(\Mockery::type(Collection::class));
        $image = \Mockery::mock(Image::class)->makePartial();

        $data = [
            'asset' => $asset,
            'image' => $image
        ];

        //act
        $this->dispatch(app(SetImagesOnAsset::class, $data));

        //assert
    }
}
