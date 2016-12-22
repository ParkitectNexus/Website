<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use PN\Assets\Asset;
use PN\Assets\Jobs\Tags\DetachPrimaryTagsFromAsset;
use PN\Assets\Tag;

class DetachPrimaryTagsFromAssetTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testPrimaryTagsAreDetached()
    {
        //arrange
        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->type = "mod";

        $tag2 = \Mockery::mock(Tag::class)->makePartial();
        $tag1 = \Mockery::mock(Tag::class)->makePartial();
        $tag3 = \Mockery::mock(Tag::class)->makePartial();

        $asset->shouldReceive("removeTag")->with($tag1)->once();
        $asset->shouldReceive("removeTag")->with($tag2)->once();
        $asset->shouldReceive("removeTag")->with($tag3)->once();
        \TagRepo::shouldReceive("findPrimary")
            ->with("mod")
            ->andReturn(new Collection([$tag1, $tag2, $tag3]));

        //act
        $this->dispatch(app(DetachPrimaryTagsFromAsset::class, [$asset]));

        //assert
    }

}
    