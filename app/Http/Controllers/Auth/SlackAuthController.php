<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers,
    App\Http\Controllers\Controller;

class SlackAuthController extends Controller
{
    use AuthenticatesUsers;

    const AUTH_SCOPE = [
        'identity.basic',
        'identity.email',
        'identity.team',
        'identity.avatar',
    ];

    const PERMISSION_SCOPE = [
        'emoji:read',
        'users.profile:read',
        'users.profile:write',
        'channels:read',
    ];

    public function redirectToProvider()
    {
        $this->middleware('guest')->except('logout');
        return \Socialite::driver('slack')->scopes(self::AUTH_SCOPE)->redirect();
    }

    public function getPermission()
    {
        return \Socialite::driver('slack')->scopes(self::PERMISSION_SCOPE)->redirect();
    }

    public function handleProviderCallback()
    {
        $this->middleware('guest')->except('logout');
        $user = \Socialite::driver('slack')->user();

        $authUser = $this->firstOrCreateUser($user);
        \Auth::login($authUser, true);

        $scope = $user->accessTokenResponseBody['scope'];
        $slackTeam = (object) $user['team'];
        $team = \App\Team::firstOrNew(['slack_team_id' => $slackTeam->id]);
        $team->fill(['name' => $slackTeam->name, 'avatar' => $slackTeam->image_230])->save();
        $teamUser = \App\TeamUser::firstOrCreate(['user_id' => $authUser->id, 'team_id' => $team->id]);

        if(strpos($scope, self::PERMISSION_SCOPE[0]) !== false) {
            $teamUser->fill(['slack_access' => 1])->save();
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        $this->middleware('guest')->except('logout');
        \Auth::logout();
        return redirect()->route('login');
    }

    protected function firstOrCreateUser($slackUser)
    {
        $authUser = \App\User::where('slack_user_id', $slackUser->id)->first();
        if ($authUser) return $authUser;

        return \App\User::create([
            'name' => $slackUser->name,
            'slack_token' => $slackUser->token,
            'slack_user_id' => $slackUser->id,
            'avatar' => $slackUser['user']['image_512'],
        ]);
    }

}
