<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;

class SlackAuthController extends Controller
{
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

        \Log::info($user->token);
        $authUser = $this->findOrCreateUser($user);

//        Auth::login($authUser, true);

        return redirect('/home');
//        return redirect()->route('home');
    }


    private function findOrCreateUser($slackUser)
    {
//        dd($slackUser);
//        $authUser = User::where('twitter_id', $twitterUser->id)->first();
//
//        if ($authUser){
//            return $authUser;
//        }
//
//        return User::create([
//            'name' => $twitterUser->name,
//            'handle' => $twitterUser->nickname,
//            'twitter_id' => $twitterUser->id,
//            'avatar' => $twitterUser->avatar_original
//        ]);
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
