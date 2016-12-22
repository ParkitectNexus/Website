<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Resources\Jobs\CreateResource;

class ParkPrimaryTagCest
{
    public function testPark(FunctionalTester $I)
    {
        //arrange
        //act
        $resource = $I->dispatch(new CreateResource(base_path('tests/_data/files/park.txt')));
        $primaryTags = $resource->getPrimaryTags();

        //assert
        $I->assertEmpty($primaryTags->toArray());
    }
}