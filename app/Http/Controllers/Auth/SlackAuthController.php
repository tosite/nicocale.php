<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SlackAuthController extends Controller
{
    use AuthenticatesUsers;

    protected $scope = [
                            'identity.basic',
                            'identity.email',
                            'identity.team',
                            'identity.avatar'
                        ];


    public function redirectToProvider()
    {
        return \Socialite::driver('slack')->scopes($this->scope)->redirect();
    }


    public function handleProviderCallback()
    {
        try {
            $user = \Socialite::driver('slack')->user();
        } catch (\Exception $e) {
            return redirect('auth/slack');
        }

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);

        return redirect()->route('home');
    }


    private function findOrCreateUser($slackUser)
    {
        $authUser = User::where('user_token', $slackUser->token)->first();

        if ($authUser){
            return $authUser;
        }

        return User::create([
            'name'       => $slackUser->name,
            'user_token' => $slackUser->token,
            'sns'        => 'slack',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}
