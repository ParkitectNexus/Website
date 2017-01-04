<?php


use PN\Assets\Asset;
use PN\Users\User;

class AssetControllerCest
{
    public function _before(FunctionalTester $I)
    {
        $I->factory()->seed(5, \PN\Media\Image::class);
        $I->factory()->seed(5,User::class);

        $this->user = $I->factory()->create(User::class);
        \Auth::login($this->user, false);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryUploadPark(FunctionalTester $I)
    {
        $I->amOnPage(route('assets.manage.selectfile'));
        $I->attachFile('resource', 'files/park.txt');
        $I->click('input[value=Upload]');
        $I->seeInSession("resource");
        $this->_fillOutGeneral($I);
    }

    public function tryUploadMod(FunctionalTester $I, \Step\Functional\Tag $tag)
    {
        //arrange
        //act
        $tag->generateTags();
        $I->amOnPage(route('assets.manage.selectmod'));
        $I->fillField("resource", 'https://github.com/ParkitectNexus/CoasterCam');
        $I->checkOption("terms");
        $I->click("input[value='Go!']");
        $I->seeInSession('resource');
        $I->seeCurrentRouteIs('assets.manage.create');
        $this->_fillOutGeneral($I);
        
        //assert
    }

    public function tryUploadModWithoutAcceptingTerms(FunctionalTester $I, \Step\Functional\Tag $tag)
    {
        //arrange
        //act
        $tag->generateTags();
        $I->amOnPage(route('assets.manage.selectmod'));
        $I->fillField("resource", 'https://github.com/ParkitectNexus/CoasterCam');
        $I->click("input[value='Go!']");
        $I->canSeeFormHasErrors();
        $I->seeCurrentRouteIs('assets.manage.selectmod');
        //assert
    }


    public function _fillOutGeneral(FunctionalTester $I)
    {
        $temp_asset = $I->factory()->instance(Asset::class);

        $I->fillField('input[name=name]',$temp_asset->name);
        $I->fillField('textarea[name=description]',$temp_asset->description);
        $I->click('input[type=submit]');

        $category = $I->grabRecord(Asset::class,['name' => $temp_asset->name]);
        $I->assertTrue($category->description == $temp_asset->description);

    }



}