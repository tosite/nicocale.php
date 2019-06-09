<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers,
    App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SlackAuthController extends Controller
{
    use AuthenticatesUsers;

    const AUTH_SCOPE = [
        'users:read',
        'team:read',
        'channels:read',
        'chat:write:bot',
        'users.profile:write',
    ];

    public function redirectToProvider()
    {
        $this->middleware('guest')->except('logout');
        return \Socialite::driver('slack')->scopes(self::AUTH_SCOPE)->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $slackAuth = \App\Slack::oauthAccess($request->all()['code']);
            $slack = new \App\Slack($slackAuth->access_token);
            $slackUser = $slack->usersInfo($slackAuth->user_id);
            $slackTeam = $slack->teamInfo();

            $user = $this->firstOrCreateUser($slackUser, $slackAuth);
            \Auth::login($user, true);
            $user->fill(['slack_token' => $slackAuth->access_token, 'avatar' => $slackUser->profile['image_512']])->save();

            $team = \App\Team::firstOrNew(['slack_team_id' => $slackAuth->team_id]);
            $team->fill(['avatar' => $slackTeam->icon['image_230'], 'name' => $slackTeam->name])->save();
            \App\TeamUser::firstOrCreate(['user_id' => $user->id, 'team_id' => $team->id]);
        });

        return redirect()->route('teams.index');
    }

    public function logout()
    {
        $this->middleware('guest')->except('logout');
        \Auth::logout();
        return redirect()->route('login');
    }

    protected function firstOrCreateUser($slackUser, $slackAuth)
    {
        $authUser = \App\User::where('slack_user_id', $slackAuth->user_id)->first();
        if ($authUser) return $authUser;

        return \App\User::create([
            'name' => $slackUser->profile['real_name'],
            'slack_token' => $slackAuth->access_token,
            'slack_user_id' => $slackUser->id,
            'avatar' => $slackUser->profile['image_512'],
        ]);
    }

}
