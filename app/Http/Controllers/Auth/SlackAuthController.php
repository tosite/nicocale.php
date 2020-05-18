<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers,
    App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SlackAuthController extends Controller
{
    use AuthenticatesUsers;

    const AUTH_SCOPE = [
        'identity.basic',
        'identity.team',
        'identity.avatar',
        'identity.email',
    ];

    const PERMISSION_SCOPE = [
        'channels:read',
        'chat:write:bot',
        'users.profile:write',
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

    public function handleProviderCallback(Request $request)
    {
        if (!empty($request->get('error'))) {
            return redirect()->back()->with('flash_message', 'ログインに失敗しました。');
        }

        try {
            $user = \Socialite::driver('slack')->user();
        } catch (\Exception $e) {
            $user = \Socialite::driver('slack')->stateless()->user();
        }

        \DB::transaction(function () use ($user) {
            $authUser = $this->firstOrCreateUser($user);
            $token = auth('api')->login($authUser);
            session(['jwt_token' => $token]);
            auth('web')->login($authUser);
            if ($authUser->slack_token !== $user->token) {
                $authUser->slack_token = $user->token;
                $authUser->save();
            }

            $scope = $user->accessTokenResponseBody['scope'];
            $slackTeam = (object)$user['team'];
            $team = \App\Team::firstOrNew(['slack_team_id' => $slackTeam->id]);
            $team->fill(['avatar' => $slackTeam->image_230, 'name' => $slackTeam->name])->save();
            $teamUser = \App\TeamUser::firstOrCreate(['user_id' => $authUser->id, 'team_id' => $team->id]);

            if (strpos($scope, self::PERMISSION_SCOPE[1]) !== false) {
                $teamUser->slack_access(true);
            }
        });

        return redirect()->route('teams.index');
    }

    public function logout()
    {
        $this->middleware('guest')->except('logout');
        \Auth::logout();
        return redirect()->route('login');
    }

    protected function firstOrCreateUser($slackUser): \App\User
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
