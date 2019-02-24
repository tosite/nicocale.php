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
//    public function __construct ()
//    {
//        $this->middleware('guest')->except('logout');
//    }

    public function redirectToProvider ()
    {
        $this->middleware('guest')->except('logout');
        $scope = [
            'identity.basic',
            'identity.email',
            'identity.team',
            'identity.avatar',
        ];
        return \Socialite::driver('slack')->scopes($scope)->redirect();
    }

    public function getPermission () {
        $scope = [
            'emoji:read',
            'users.profile:read',
            'users.profile:write',
        ];
        return \Socialite::driver('slack')->scopes($scope)->redirect();
    }

    public function handleProviderCallback ()
    {
        $this->middleware('guest')->except('logout');
        try {
            $user = \Socialite::driver('slack')->user();
        }
        catch (\Exception $e) {
            \Log::error($e);
            return redirect('/auth/slack');
        }

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);

        $team = \App\Team::findOrCreateTeam($user['team']);
        \App\TeamUser::firstOrCreateTeamUser($authUser, $team);

        return redirect()->route('home');
    }


    private function findOrCreateUser ($slack_user)
    {
//        $authUser = User::where('slack_token', $slack_user->token)->first();
        $authUser = User::where('slack_user_id', $slack_user->id)->first();
        if ($authUser) return $authUser;

        dd($slack_user, $slack_user->token, $authUser);
        return User::create([
                'name'          => $slack_user->name,
                'slack_token'   => $slack_user->token,
                'slack_user_id' => $slack_user->id,
                'avatar'        => $slack_user['user']['image_512'],
                'sns'           => 'slack',
        ]);
    }

    public function logout ()
    {
        $this->middleware('guest')->except('logout');
        Auth::logout();
        return redirect()->route('login');
    }
}
