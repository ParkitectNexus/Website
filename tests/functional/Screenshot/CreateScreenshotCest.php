<?php

use League\FactoryMuffin\Facade as FactoryMuffin;
use PN\Users\Jobs\RegenerateApiKey;
use PN\Users\User;

class CreateScreenshotCest
{

    public function _before(FunctionalTester $I)
    {
        //arrange
        $this->user = $I->factory()->create(User::class);
    }

    public function _after(FunctionalTester $I)
    {
    }


    public function tryCreateScreenshot(FunctionalTester $I)
    {
        //act
        $I->amLoggedAs($this->user);
        $I->dispatch(new RegenerateApiKey($this->user));
        $I->haveHttpHeader('Authorization', $this->user->api_key);
        $I->sendPOST("/api/screenshot/create", [
            'title' => 'Nice screenie mate'
        ], [
            'screenshot' => base_path('tests/_data/files/image.jpg')
        ]);

        //assert
        $screenshot = \ScreenshotRepo::findWhere([
            'user_id' => $this->user->id,
            'title' => 'Nice screenie mate'
        ])->first();
        $I->assertTrue($screenshot->title == 'Nice screenie mate');
        $I->assertTrue($screenshot->getUser()->id == $this->user->id);

    }


}
