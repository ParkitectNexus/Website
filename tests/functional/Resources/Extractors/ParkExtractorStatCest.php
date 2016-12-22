<?php

use Illuminate\Support\Collection;
use PN\Resources\Extractors\ParkExtractor;

class ParkExtractorStatCest
{
    public function verifyParkStats(FunctionalTester $I)
    {
        //arrange
        $expectedStats = new Collection([
            "SizeX" => 100,
            "SizeY" => 100,
            "Money" => -438321.25,
            "ParkEntranceFee" => 0.0,
            "RatingPriceSatisfaction" => 79,
            "RatingCleanliness" => 34,
            "RatingHappiness" => 50,
            "ParkYear" => 71.0,
            "GuestCount" => 0
        ]);

        //act
        $parkExtractor = new ParkExtractor(base_path('tests/_data/files/park.txt'));

        //assert
        $I->assertEquals($expectedStats, $parkExtractor->getStats());
    }
}