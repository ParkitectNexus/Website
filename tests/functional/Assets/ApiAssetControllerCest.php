<?php


namespace functional\Assets;


use FunctionalTester;
use PN\Foundation\Option;

class ApiAssetControllerCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryRequire(FunctionalTester $I)
    {
        $I->factory()->create(Option::class, ["id" => 'required_assets', 'value' => '1,2,3,4']);
        $I->sendGET("api/assets/required");
        $I->canSeeResponseCodeIs(200);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseContainsJson(["data" => ["1", "2", "3", "4"]]);
    }
}