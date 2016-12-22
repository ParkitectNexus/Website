<?php

namespace PN\Users\Http\Controllers;


use Auth;
use Illuminate\Support\Str;
use Invisnik\LaravelSteamAuth\SteamAuth;
use PN\Foundation\Http\Controllers\Controller;
use PN\Users\Exceptions\SteamAuthFailedException;
use PN\Users\Exceptions\UserNotFound;
use PN\Users\Http\Requests\SetUsernameRequest;
use PN\Users\Jobs\CreateSocialUser;
use PN\Users\Jobs\SetSteamIdOnUser;
use PN\Users\Jobs\SetUsername;
use PN\Users\Repositories\UserRepositoryInterface;

class SocialAuthController extends Controller
{

    /**
     * @param \Request $request
     * @return mixed
     */
    public function getGithub(\Request $request)
    {
        return \Socialite::with('github')->redirect();
    }

    /**
     * @param \Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getGithubCallback(\Request $request)
    {
        return $this->callback('github');
    }

    /**
     * @param \Request $request
     * @return mixed
     */
    public function getFacebook(\Request $request)
    {
        return \Socialite::with('facebook')->redirect();
    }

    public function getSteam()
    {
        $steam = app(SteamAuth::class);

        if ($steam->validate()) {
            return $this->getSteamCallback($steam);
        }

        return $steam->redirect();
    }

    /**
     * @param \Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getFacebookCallback(\Request $request)
    {
        return $this->callback('facebook');
    }

    /**
     * @param \Request $request
     * @return mixed
     */
    public function getGoogle(\Request $request)
    {
        return \Socialite::with('google')->redirect();
    }

    /**
     * @param \Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getGoogleCallback(\Request $request)
    {
        return $this->callback('google');
    }

    private function callback($driver)
    {
        if (\Request::has('code')) {
            $userData = \Socialite::with($driver)->user();

            $user = \UserRepo::findBySocial($userData->id, $driver, $userData->email);

            if($user == null) {
                $user = $this->dispatch(app(CreateSocialUser::class, [
                    $userData->name,
                    $userData->email,
                    $userData->avatar,
                    $userData->id,
                    $driver
                ]));
            } else {
                $user->fill([
                    'social_name' => $driver,
                    'social_id' => $userData->id,
                    'avatar' => $userData->avatar
                ]);

                \UserRepo::edit($user);
            }

            if ($user->username == '') {
                return redirect(route('socialauth.setusername', [\Crypt::encrypt($user->identifier)]));
            }

            \Auth::login($user, true);

            if (\Session::get('client-login', false)) {
                return redirect('api/auth/apikey');
            }
        }

        return \Redirect::intended(route('home.index'));
    }

    public function getSteamCallback($steam)
    {
        $info = $steam->getUserInfo();

        if (!is_null($info)) {
            // steam provides no emails, generate one based on id
            $email = $info->getSteamID64() . '@steam.com';

            // try to find someone who is already linked with steam, if they do we need to log them in without doing anything
            $user = \UserRepo::findBySteamId($info->getSteamID64());

            // couldnt find it
            if ($user == null) {
                // if someone is already logged in, this is a call to link steam to an existing account
                if(\Auth::check()) {
                    $user = \Auth::user();

                    $this->dispatch(new SetSteamIdOnUser($user, $info->getSteamID64()));

                    \Notification::info('Steam was successfully linked to your account');
                } else {
                    // this is a call to create a new user with steam
                    $user = $this->dispatch(new CreateSocialUser(
                        $info->getName(),
                        $email,
                        $info->getProfilePictureFull(),
                        '', // don't copy steam username, let them choose themselves
                        'steam'
                    ));

                    $this->dispatch(new SetSteamIdOnUser($user, $info->getSteamID64()));

                    if ($user->username == '') {
                        return redirect(route('socialauth.setusername', [\Crypt::encrypt($user->identifier)]));
                    }
                }
            } else {
                // user was found, just log the user in
                \Auth::login($user);
            }

            $user->avatar = $info->getProfilePictureFull();

            \UserRepo::edit($user);

            return redirect($user->getPresenter()->url());
        }

        // should never come here but an exception anyways
        throw new SteamAuthFailedException();
    }

    /**
     * @param $encryptedIdentifier
     * @return $this
     * @throws UserNotFound
     */
    public function getSetUsername($encryptedIdentifier)
    {
        $identifier = \Crypt::decrypt($encryptedIdentifier);

        $user = \UserRepo::findByIdentifier($identifier);

        if($user == null) {
            throw new UserNotFound($identifier);
        }

        if ($user->username != '') {
            abort(418);
            exit;
        }

        $view = 'auth.set-username';

        if (\Session::get('client-login', false)) {
            $view = 'api.auth.set-username';
        }

        return view($view, [
            'encryptedIdentifier' => $encryptedIdentifier,
            'proposedUsername' => Str::slug($user->name)
        ]);
    }

    /**
     * @param $encryptedIdentifier
     * @param SetUsernameRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSetUsername($encryptedIdentifier, SetUsernameRequest $request)
    {
        $identifier = \Crypt::decrypt($encryptedIdentifier);

        $user = \UserRepo::findByIdentifier($identifier);

        $user = $this->dispatch(app(SetUsername::class, [$user->id, \Request::get('username')]));

        \Auth::login($user, true);

        if (\Session::pull('client-login', false)) {
            return redirect('api/auth/apikey');
        }

        return redirect(route('home.index'));
    }

}
