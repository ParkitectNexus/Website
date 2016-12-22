<?php


use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Assets\Asset;
use PN\Assets\Jobs\ParticipateInBuildOff;
use PN\Assets\Tag;
use PN\BuildOffs\BuildOff;
use PN\BuildOffs\Exceptions\AssetMayNotParticipateInBuildOff;

class ParticipateInBuildOffTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testParticipation()
    {
        //arrange
        $tag1 = \Mockery::mock(Tag::class)->makePartial();
        $tag1->id = 100;
        $tag2 = \Mockery::mock(Tag::class)->makePartial();
        $tag2->id = 200;
        $tag3 = \Mockery::mock(Tag::class)->makePartial();
        $tag3->id = 44;

        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->type = 'blueprint';
        $asset->shouldReceive("getTags")->andReturn([$tag1, $tag2, $tag3]);
        $asset->id = 4123;

        $buildOff = \Mockery::mock(BuildOff::class)->makePartial();
        $buildOff->type_requirement = 'blueprint';
        $buildOff->tag_id = 44;
        $buildOff->id = 100;

        \AssetRepo::shouldReceive("edit")
            ->with(\Mockery::type(Asset::class))->once();

        //act
        $this->dispatch(new ParticipateInBuildOff($asset, $buildOff));

        //assert
        $this->assertEquals($asset->buildoff_id, $buildOff->id);

    }

    public function testParticipationWrongType()
    {
        //arrange
        $this->setExpectedException(AssetMayNotParticipateInBuildOff::class);

        $tag1 = \Mockery::mock(Tag::class)->makePartial();
        $tag1->id = 100;
        $tag2 = \Mockery::mock(Tag::class)->makePartial();
        $tag2->id = 200;
        $tag3 = \Mockery::mock(Tag::class)->makePartial();
        $tag3->id = 44;

        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->type = 'park';
        $asset->shouldReceive("getTags")->andReturn([$tag1, $tag2, $tag3]);
        $asset->id = 4123;

        $buildOff = \Mockery::mock(BuildOff::class)->makePartial();
        $buildOff->type_requirement = 'blueprint';
        $buildOff->tag_id = 44;
        $buildOff->id = 100;

        //act
        $this->dispatch(new ParticipateInBuildOff($asset, $buildOff));

        //assert
        $this->assertEquals($asset->buildoff_id, $buildOff->id);
    }

    public function testParticipationWrongTag()
    {
        //arrange
        $this->setExpectedException(AssetMayNotParticipateInBuildOff::class);

        $tag1 = \Mockery::mock(Tag::class)->makePartial();
        $tag1->id = 100;
        $tag2 = \Mockery::mock(Tag::class)->makePartial();
        $tag2->id = 200;
        $tag3 = \Mockery::mock(Tag::class)->makePartial();
        $tag3->id = 55;

        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->type = 'park';
        $asset->shouldReceive("getTags")->andReturn([$tag1, $tag2, $tag3]);
        $asset->id = 4123;

        $buildOff = \Mockery::mock(BuildOff::class)->makePartial();
        $buildOff->type_requirement = 'blueprint';
        $buildOff->tag_id = 44;
        $buildOff->id = 100;

        //act
        $this->dispatch(new ParticipateInBuildOff($asset, $buildOff));

        //assert
        $this->assertEquals($asset->buildoff_id, $buildOff->id);
    }
}