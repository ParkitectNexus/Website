<?php


use PN\Users\User;

class AssetControllerCest
{
    public function _before(FunctionalTester $I)
    {
        $this->user = $I->factory()->create(User::class);
        \Auth::login($this->user, false);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryFileUpload(FunctionalTester $I)
    {
        //arrange
        //act
        $I->amOnPage(route('assets.manage.selectfile'));
        $I->attachFile('resource', 'files/park.txt');
        $I->click('input[value=Upload]');
        $I->seeInSession("resource");

        //assert
    }

    public function tryModUpload(FunctionalTester $I)
    {
        //arrange
        //act
        $I->amOnPage(route('assets.manage.selectmod'));
        $I->fillField("resource", 'https://github.com/ParkitectNexus/CoasterCam');
        $I->checkOption("accept");
        $I->click("input[value='Go!']");
        $I->seeInSession('resource');

        //assert
    }
}