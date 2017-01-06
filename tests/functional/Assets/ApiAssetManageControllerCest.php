<?php
/**
 * Created by PhpStorm.
 * User: michaelpollind
 * Date: 1/6/17
 * Time: 9:48 PM
 */

namespace functional\Assets;


use FunctionalTester;

class ApiAssetManageControllerCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryApiUpload(FunctionalTester $I)
    {
        $I->sendPOST("api/assets/manage/upload-asset",[],['resource' => codecept_data_dir('files/park.txt')]);
        $I->seeResponseCodeIs(200);
        $I->see("assets/manage/create");
    }
}