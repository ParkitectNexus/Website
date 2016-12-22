<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Assets\Asset;
use PN\Assets\Events\TagWasDetachedFromAsset;
use PN\Assets\Jobs\Tags\DetachTagFromAsset;
use PN\Assets\Tag;

class DetachTagFromAssetTest extends \Codeception\Test\Unit
{

    use DispatchesJobs;

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testTagDetachesFromAsset()
    {
        //arrange

        $tag = \Mockery::mock(Tag::class)->makePartial();
        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->shouldReceive("removeTag")
            ->with(\Mockery::type(Tag::class))->once();

        //act
        $this->dispatch(app(DetachTagFromAsset::class, [$asset, $tag]));

        //assert

        $this->tester->canSeeEventTriggered(TagWasDetachedFromAsset::class);
    }
}
