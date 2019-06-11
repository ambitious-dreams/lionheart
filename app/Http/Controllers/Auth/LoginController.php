<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Repositories\UserRepository;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('guest')->except('logout');
        $this->userRepo = $userRepo;
    }

    public function redirectToProvider($provider)
    {
        request()->merge(['provider' => $provider]);
        $this->validate(request(), [
            'provider' => 'required|in:facebook,google',
        ]);

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $userData = Socialite::driver($provider)->user();
        $user = $this->userRepo->findOAuthUser($provider, $userData);

        if ($user) {
            $this->userRepo->logIn($user);
            return redirect($this->redirectPath());
        }

        $validationResult = $this->userRepo->validateOAuthUser($userData);

        if ($validationResult !== true) {
            return $validationResult;
        }

        $user = $this->userRepo->createOAuthUser($userData, $provider);

        $this->userRepo->logIn($user);
        return redirect($this->redirectPath());
    }
}
