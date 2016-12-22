<?php


use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Resources\Jobs\CreateResource;

class BlueprintPrimaryTagCest
{
    public function tryOldBlueprintStyle(FunctionalTester $I)
    {
        //arrange
        $resource = $I->dispatch(new CreateResource(base_path('tests/_data/files/blueprints/old_style.png')));

        //act
        $primaryTags = $resource->getPrimaryTags();

        //assert
        $I->assertTrue($primaryTags->contains("HasCoaster"));
        $I->assertTrue($primaryTags->contains("RollerCoaster"));
        $I->assertTrue($primaryTags->contains("WoodenCoaster"));
    }

    public function tryNewBlueprintStyle(FunctionalTester $I)
    {
        //arrange
        $resource = $I->dispatch(new CreateResource(base_path('tests/_data/files/blueprints/new_style.png')));

        //act
        $primaryTags = $resource->getPrimaryTags();

        //assert
        $I->assertTrue($primaryTags->contains("HasScenery"));
        $I->assertTrue($primaryTags->contains("HasCoaster"));
        $I->assertTrue($primaryTags->contains("RollerCoaster"));
        $I->assertTrue($primaryTags->contains("LogFlume"));
    }

    public function tryScenery(FunctionalTester $I)
    {
        //arrange
        $resource = $I->dispatch(new CreateResource(base_path('tests/_data/files/blueprints/scenery.png')));

        //act
        $primaryTags = $resource->getPrimaryTags();

        //assert
        $I->assertTrue($primaryTags->contains("HasScenery"));
        $I->assertTrue($primaryTags->contains("HasOnlyScenery"));
    }

    public function trySceneryFlatRide(FunctionalTester $I)
    {
        //arrange
        $resource = $I->dispatch(new CreateResource(base_path('tests/_data/files/blueprints/scenery_flatride.png')));

        //act
        $primaryTags = $resource->getPrimaryTags();

        //assert
        $I->assertTrue($primaryTags->contains("HasScenery"));
        $I->assertTrue($primaryTags->contains("HasFlatRide"));
    }
}