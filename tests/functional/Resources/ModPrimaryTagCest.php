<?php

use PN\Resources\Jobs\CreateResource;

class ModPrimaryTagCest
{

    public function testPark(FunctionalTester $I)
    {
        //arrange

        //act
        $resource = $I->dispatch(new CreateResource("https://github.com/ParkitectNexus/CoasterCam"));
        $primaryTags = $resource->getPrimaryTags();

        //assert
        $I->assertEmpty($primaryTags->toArray());
    }
}