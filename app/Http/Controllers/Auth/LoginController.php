<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * Redirect the user to the google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $name = $user->name;
        $email = $user->email;
        if (empty($name)) {
            $name = $user->email;
        }
        $password = $user->id;
        if ($this->autenticar($email, $password)) {
            // Authentication passed...
            return redirect()->intended('home');
        } else {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            if ($this->autenticar($email, $password)) {
                // Authentication passed...
                return redirect()->intended('home');
            }
        }
    }
    public function autenticar($email, $password)
    {
        if (\Auth::attempt(['email' => $email, 'password' => $password])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Envia al usuario a la pagina de inicio de GitHub.
     */
    // public function redirectToGitHub()
    // {
    //     return Socialite::driver('github')->redirect();
    // }
    // public function handleGitHubCallback()
    // {
    //     $githubUser = Socialite::driver('github')->user();
    //     return "Bienvenido {$githubUser->name} ({$githubUser->nickname})";
    // }
}
