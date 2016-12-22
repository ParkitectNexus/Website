<?php


use Illuminate\Contracts\Mail\Mailer;
use League\FactoryMuffin\Facade as FactoryMuffin;
use PN\Assets\Asset;
use PN\Users\Jobs\GenerateNewPasswordToken;
use PN\Users\User;

class AuthControllerCest
{

    public function _before(FunctionalTester $I)
    {
        \Auth::logout();
        $I->factory()->seed(5,\PN\Media\Image::class);
        $this->user = $I->factory()->create(User::class);
        $I->factory()->seed(5,"mod:" . Asset::class);
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToLogout(FunctionalTester $I)
    {
        \Auth::login($this->user, false);

        //act
        $I->amOnPage(route('auth.logout'));
        $I->seeCurrentRouteIs('home.index');

        //assert
        $this->user = \UserRepo::find($this->user->id);
        $I->assertFalse(\Auth::check(),"User should not be logged in");
        $I->assertTrue(\Auth::user() == null,"User should be null");
    }

    public function trySetNewPassword(FunctionalTester $I)
    {
        //arrange
        $new_password = str_random(10);
        $I->dispatch(new GenerateNewPasswordToken($this->user));

        //act
        $I->amOnPage(route('auth.newpassword') . "/" . $this->user->password_token );
        $I->fillField("email",$this->user->email);
        $I->fillField("password",$new_password);
        $I->fillField("password_confirmation",$new_password);
        $I->click('button[type=submit]');
        $I->seeCurrentRouteIs('home.index');

        //assert
        $this->user = \UserRepo::find($this->user->id);
        $I->assertTrue(\Auth::check(),"User should be logged in");
        $I->assertTrue(\Auth::user()->id == $this->user->id,"Auth user should match");
        $I->assertTrue(\Hash::check($new_password,$this->user->password),"Password is invalid");
    }

    public function trySetNewPasswordWithInvalidTokenPost(FunctionalTester $I)
    {
        //arrange
        $new_password = str_random(10);
        $I->dispatch(new GenerateNewPasswordToken($this->user));

        //act
        $I->amOnPage(route('auth.newpassword') . "/invalid token");
        $I->fillField("email",$this->user->email);
        $I->fillField("password",$new_password);
        $I->fillField("password_confirmation",$new_password);
        $I->click('button[type=submit]');
        $I->seeCurrentRouteIs('home.index');

        //assert
        $this->user = \UserRepo::find($this->user->id);
        $I->assertFalse(\Auth::check(),"Is user logged in");
        $I->assertTrue(\Auth::user()== null,"User Should be logged out");
        $I->assertFalse(\Hash::check($new_password,$this->user->password),"Password should be invalid");

    }

    public function  trySubmitForgotPassword(FunctionalTester $I){
        //arrange
        $I->haveBinding('mailer',function(){
            $mail = \Mockery::mock(Mailer::class);
            $mail->shouldReceive("send")->with(\Mockery::any(),\Mockery::any(),\Mockery::any())->once();

            return $mail;

        });

        //act
        $I->amOnPage(route('auth.forgotpassword'));
        $I->fillField("email",$this->user->email);
        $I->click('Request new password');
        $I->seeCurrentRouteIs('auth.forgotpassword');

        \Mockery::close();

        //assert
        $this->user = \UserRepo::find($this->user->id);
        $I->assertTrue($this->user->password_token != null,"Password token isn't set");


    }

    public  function  tryRegister(FunctionalTester $I){
        //arrange
        $user = $I->factory()->instance(User::class);
        $I->disableEvents();
        $new_password = str_random(10);


        $I->haveBinding('captcha',function(){
            $no_captcha = \Mockery::mock(Anhskohbo\NoCaptcha\NoCaptcha::class);
            // prevent validation error on captcha
            $no_captcha->shouldReceive('verifyResponse')
                ->andReturn(true);
            // provide hidden input for your 'required' validation
            $no_captcha->shouldReceive('display')
                ->zeroOrMoreTimes()
                ->andReturn('<input type="hidden" name="g-recaptcha-response" value="1" />');
            return $no_captcha;
        });

        //act
        $I->amOnPage(route('auth.register'));
        $I->fillField("username",$user->username);
        $I->fillField("name",$user->name);
        $I->fillField("email",$user->email);
        $I->fillField("password",$new_password);
        $I->fillField("password_confirmation",$new_password);
        $I->click('button[type=submit]');
        $I->seeCurrentRouteIs('auth.login');
        //$I->cantSeeEventTriggered(UserRegistered::class);

        \Mockery::close();
        //assert
        $registered_user = \UserRepo::findByField('email',$user->email)->first();
        $I->assertFalse(\Auth::check());
        $I->assertTrue($user->name == $registered_user->name);
        $I->assertTrue($user->username == $registered_user->username);
        $I->assertTrue($user->email == $registered_user->email);
        $I->assertTrue(\Hash::check($new_password,$registered_user->password));
    }

    public  function  tryLogin(FunctionalTester $I)
    {
        //arrange
        //act
        $I->amOnPage(route('auth.login'));
        $I->fillField('email',$this->user->email);
        $I->fillField('password','password');
        $I->click('button[type=submit]');
        $I->seeCurrentRouteIs('home.index');

        //assert
        $user = \UserRepo::find($this->user->id);
        $I->assertTrue(\Auth::check(),"User is logged out");
        $I->assertTrue(\Auth::user()->id == $user->id,"user does not match for login");
        $I->assertTrue(\Hash::check('password',$user->password),"password is invalid valid");
    }

    public function tryLoginWithInvalidEmail(FunctionalTester $I)
    {
        //arrange
        //act
        $I->amOnPage(route('auth.login'));
        $I->fillField('email','info@email.com');
        $I->fillField('password','password');
        $I->click('button[type=submit]');
        $I->canSeeFormHasErrors();
        $I->seeFormErrorMessages(['User not found']);
        //assert
    }



}
