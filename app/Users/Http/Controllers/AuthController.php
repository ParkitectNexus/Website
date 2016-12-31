<?php
namespace PN\Users\Http\Controllers;

use PN\Foundation\Http\Controllers\Controller;
use PN\Users\Exceptions\UserNotConfirmed;
use PN\Users\Exceptions\UserNotFound;
use PN\Users\Http\Requests\LoginRequest;
use PN\Users\Http\Requests\RegisterRequest;
use PN\Users\Http\Requests\RequestNewPasswordRequest;
use PN\Users\Http\Requests\SetNewPasswordRequest;
use PN\Users\Jobs\ChangePassword;
use PN\Users\Jobs\ConfirmUser;
use PN\Users\Jobs\GenerateNewPasswordToken;
use PN\Users\Jobs\RegisterUser;
use PN\Users\Jobs\SendConfirmEmail;
use PN\Users\Jobs\SendNewPasswordRequestEmail;
use PN\Users\Repositories\UserRepositoryInterface;

/**
 * Class AuthController
 * @package ParkitectNexus\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * @param RegisterRequest $register
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterRequest $register)
    {
        $this->dispatch(app(RegisterUser::class, array_values(\Request::only([
            'username',
            'name',
            'email',
            'password'
        ]))));
        
        return redirect(route('auth.login'));
    }

    /**
     * @param $email
     * @return \Illuminate\Http\RedirectResponse
     * @throws UserDoesNotExist
     */
    public function getResend($email)
    {
        $user = \UserRepo::findByEmail($email);

        if ($user->confirmed == 0) {
            $this->dispatch(new SendConfirmEmail($user));
        }

        \Notification::info('Mail resent!');

        return \Redirect::route('auth.login');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $login
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $login)
    {
        try {
            $valid = \UserRepo::validateCredentials(request('email'), request('password'));

            if ($valid) {
                $user = \UserRepo::findByEmail(\Request::get('email'));

                \Auth::login($user, \Request::get('remember', false));

                return \Redirect::intended();
            }

            throw new UserNotFound();
        } catch (UserNotFound $e) {
            return \Redirect::back()->withErrors(["User not found"]);
        } catch (UserNotConfirmed $e) {
            \Notification::error('Please check your email to confirm your account, <a href="' . route('auth.resend', [request('email')]) . '">Resend mail</a>');

            return \Redirect::back();
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getConfirm($token)
    {
        try {
            $user = \UserRepo::findByConfirmToken($token);

            if($user->social == 1) {
                abort(401);
            }

            $this->dispatch(new ConfirmUser($user));

            \Auth::login($user, true);

            return \Redirect::intended('/');
        } catch (UserNotFound $e) {
            \Notification::error('User does not exist');

            return redirect(route('auth.register'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function getForgotPassword()
    {
        return view('auth.request-password');
    }

    /**
     * @param RequestNewPasswordRequest $newPasswordRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postForgotPassword(RequestNewPasswordRequest $newPasswordRequest)
    {
        try {
            $user = \UserRepo::findByEmail(request('email'));

            $this->dispatch(new GenerateNewPasswordToken($user));

            $this->dispatch(new SendNewPasswordRequestEmail($user));
        } catch (UserNotFound $e) {

        }

        \Notification::info('A link to reset your password has been sent to ' . request('email'));

        return \Redirect::back();
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\View
     */
    public function getSetNewPassword($token)
    {
        return view('auth.set-password', compact('token'));
    }

    /**
     * @param $token
     * @param SetNewPasswordRequest $newPassword
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSetNewPassword($token, SetNewPasswordRequest $newPassword)
    {
        try {
            $user = \UserRepo::findByEmail(request('email'));

            if ($user->password_token == $token) {
                $this->dispatch(new ChangePassword($user, request('password')));
                
                \Auth::login($user, true);
                
                return \Redirect::intended();
            }

            return \Redirect::route("home.index");
        } catch (UserNotFound $e) {
            \Notification::error('The entered credentials do not match our records');

            return \Redirect::back();
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        \Auth::logout();

        return \Redirect::back();
    }
}
