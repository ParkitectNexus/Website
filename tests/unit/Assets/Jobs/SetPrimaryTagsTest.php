<?php


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use PN\Assets\Asset;
use PN\Assets\Jobs\SetPrimaryTags;
use PN\Assets\Tag;
use PN\Resources\Jobs\CreateResource;
use PN\Resources\Resource;

class SetPrimaryTagsTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testTagsAreAttachedMod()
    {
        //arrange
        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->shouldReceive("addTag")->never();

        $resource = \Mockery::mock(Resource::class)->makePartial();
        $resource->type = "mod";
        $asset->shouldReceive("getResource")->andReturn($resource);

        \TagRepo::shouldReceive("findByPrimaryTags")->with([])->andReturn([]);

        //act
        $this->dispatch(app(SetPrimaryTags::class, [$asset]));

        //assert
    }

    public function testTagsAreAttachedBlueprint()
    {
        //arrange
        $asset = \Mockery::mock(Asset::class)->makePartial();
        $asset->shouldReceive("addTag")
            ->with(\Mockery::type(Tag::class))
            ->times(3);
        $resource = $this->dispatch(
            new CreateResource(base_path('tests/_data/files/blueprints/new_style.png')));
        $asset->shouldReceive("getResource")->andReturn($resource);

        $tag1 = \Mockery::mock(Tag::class)->makePartial();
        $tag2 = \Mockery::mock(Tag::class)->makePartial();
        $tag3 = \Mockery::mock(Tag::class)->makePartial();

        \TagRepo::shouldReceive("findByPrimaryTags")->with([
            'HasScenery',
            'HasCoaster',
            'RollerCoaster',
            'LogFlume'
        ])->andReturn(new Collection([$tag1, $tag2, $tag3]))->once();

        //act
        $this->dispatch(app(SetPrimaryTags::class, [$asset]));

        //assert
    }


    //TODO write a park test
}
