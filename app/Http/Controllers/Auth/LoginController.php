<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);

        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  AbstractUser $user Socialite user object
     * @param String $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->getId())->first();
        if ($authUser)
        {
            return $authUser;
        }

        // If a user account already exists for this email, then merge
        $emailUser = User::where('email', $user->getEmail())->first();
        if ($emailUser)
        {
            $emailUser->update([
                'nickName'    => $emailUser->nickName ?? $user->getNickname() ?? $user->getName(),
                'provider'    => $provider,
                'provider_id' => $user->getId(),
                'avatar'      => $user->getAvatar(),
                'status'      => 1
            ]);

            return $emailUser;
        }

        return User::create([
            'nickName'    => $user->getNickname() ?? $user->getName(),
            'email'       => $user->getEmail(),
            'provider'    => $provider,
            'provider_id' => $user->getId(),
            'avatar'      => $user->getAvatar(),
            'status'      => 1
        ]);
    }

}
