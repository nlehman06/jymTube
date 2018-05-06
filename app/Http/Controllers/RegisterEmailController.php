<?php

namespace App\Http\Controllers;

use App\Notifications\UserRegisteredSuccessfully;
use App\User;
use function redirect;

class RegisterEmailController extends Controller {


    /**
     * RegisterEmailController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('auth.registerEmail');
    }

    public function store()
    {
        $data = request()->validate([
            'email' => 'required|email'
        ]);

        auth()->user()->update(['email' => $data['email']]);

        return redirect('/home');
    }

    public function resend()
    {
        auth()->user()->update(['activation_code' => str_random(30) . time()]);

        auth()->user()->notify(new UserRegisteredSuccessfully(auth()->user()));

        return redirect(route('activate.reminder'));
    }

    public function congrats()
    {
        return view('auth.congrats');
    }

    public function rememberToActivate()
    {
        return view('auth.reminder');
    }

    /**
     * Activate the user with given activation code.
     * @param string $activationCode
     * @return string
     */
    public function activateUser(string $activationCode)
    {
        try
        {
            $user = app(User::class)->where('activation_code', $activationCode)->first();
            if (!$user)
            {
                return "The code does not exist for any user in our system.";
            }
            $user->status = 1;
            $user->activation_code = null;
            $user->save();
            auth()->login($user);
        } catch (\Exception $exception)
        {
            logger()->error($exception);

            return "Whoops! something went wrong.";
        }

        return redirect()->to(route('activate.congrats'));
    }
}
