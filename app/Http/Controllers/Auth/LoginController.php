<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
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
        $user = Socialite::driver($provider)->user();

        $result = $this->userRepo->createOrFindOAuthUser($provider, $user->getId(), [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'avatar' => $user->getAvatar(),
        ]);

        if (is_object($result) && get_class($result) == 'Illuminate\Http\RedirectResponse') {
            return $result;
        }

        Auth::loginUsingId($result['user']->id);

        return redirect('/');
    }
}
