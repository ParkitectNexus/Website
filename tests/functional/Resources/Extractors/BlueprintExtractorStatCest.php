<?php

use Illuminate\Support\Collection;
use PN\Resources\Extractors\BlueprintExtractor;

class BlueprintExtractorStatCest
{
    public function verifyBlueprintExtractor(FunctionalTester $I)
    {
        //arrange
        $expectedStats = new Collection([
            "MinVertG" => -0.60203284,
            "MaxVertG" => 1.6017102,
            "MinLatG" => -1.211555,
            "MaxLatG" => 1.00424981,
            "MinLongG" => -0.955375254,
            "MaxLongG" => 0.9786002,
            "Drops" => 12,
            "TotalDropHeight" => 65.99047,
            "BiggestDrop" => 16.4996166,
            "Inversions" => 0,
            "RideLengthTime" => 102.569855,
            "RideLengthDistance" => 629.6127,
            "RatingExcitement" => 39.2307252,
            "RatingIntensity" => 20.6415921,
            "RatingNausea" => 5.46351671,
            "AirTime" => 4.599945,
            "HeadChoppers" => 7,
            "AverageSpeed" => 22.102488,
            "MaxSpeed" => 64.66144176,
            "EntranceFee" => 0.0,
            "TrainCount" => 4,
            "TrainLength" => 7,
            "TrainTotal" => 28,
            "MaximumEstimatedProfit" => 3930.9795260996,
        ]);

        //act
        $blueprintExtractor = new BlueprintExtractor(base_path('tests/_data/files/blueprint.png'));

        //assert
        $I->assertEquals($expectedStats, $blueprintExtractor->getStats());
    }
}