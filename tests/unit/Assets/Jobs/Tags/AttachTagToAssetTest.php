<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Assets\Asset;
use PN\Assets\Events\TagWasAttachedToAsset;
use PN\Assets\Jobs\Tags\AttachTagToAsset;
use PN\Assets\Tag;

class AttachTagToAssetTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testTagAttachedToAsset()
    {
        //arrange 
        $this->tester->disableEvents();

        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->shouldReceive("addTag")->with(\Mockery::type(Tag::class));
        $this->tester->cantSeeEventTriggered(TagWasAttachedToAsset::class);

        $tag = \Mockery::mock(Tag::class)->makePartial();

        //act
        $this->dispatch(new AttachTagToAsset($asset, $tag));

        //assert
    }

    public function testTagCantBeAttachedTwice()
    {
        //arrange
        $this->tester->disableEvents();

        $asset = \Mockery::mock(Asset::class)->makePartial();

        $exception = \Mockery::mock(QueryException::class);
        $asset->shouldReceive("addTag")
            ->with(\Mockery::type(Tag::class))
            ->andThrow($exception);

        $tag = \Mockery::mock(Tag::class)->makePartial();

        //act
        $this->dispatch(new AttachTagToAsset($asset, $tag));

        //assert
        $this->tester->cantSeeEventTriggered(TagWasAttachedToAsset::class);
    }
}
