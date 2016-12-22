<?php


class ExtractorNameCest
{
    public function checkBlueprintName(FunctionalTester $I)
    {
        //arrange
        //act
        $resource = \ResourceUtil::make(base_path('tests/_data/files/blueprint.png'));
        //assert
        $I->assertEquals('Trojan', $resource->getExtractor()->getName());
    }

    public function checkParkName(FunctionalTester $I)
    {
        //arrange
        //act
        $resource = \ResourceUtil::make(base_path('tests/_data/files/park.txt'));

        //assert
        $I->assertEquals('Better Starting Park', $resource->getExtractor()->getName());
    }

    public function checkModName(FunctionalTester $I)
    {
        //arrange
        //act
        $resource = \ResourceUtil::make("https://github.com/ParkitectNexus/CoasterCam");

        //assert
        $I->assertEquals('CoasterCam', $resource->getExtractor()->getName());
    }
}