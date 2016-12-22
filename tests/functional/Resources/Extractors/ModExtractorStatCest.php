<?php

use PN\Resources\Extractors\ModExtractor;

class ModExtractorStatCest
{
    public function verifyModStats(FunctionalTester $I)
    {
        //arrange
        //act
        $parkExtractor = new ModExtractor("https://github.com/ParkitectNexus/CoasterCam");

        //assert
        $I->assertEmpty($parkExtractor->getStats()->toArray());
    }
}