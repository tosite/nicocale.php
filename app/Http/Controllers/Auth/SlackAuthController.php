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
            'emoji:read',
            'users.profile:read',
            'users.profile:write',
    ];

    public function redirectToProvider ()
    {
        return \Socialite::driver('slack')->scopes($this->scope)->redirect();
    }


    public function handleProviderCallback ()
    {
        try {
            $user = \Socialite::driver('slack')->user();
        }
        catch (\Exception $e) {
            \Log::error($e);
            return redirect('auth/slack');
        }

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);

        $team = \App\Team::findOrCreateTeam($user['team']);
        \App\TeamUser::firstOrCreateTeamUser($authUser, $team);

        return redirect()->route('home');
    }


    private function findOrCreateUser ($slackUser)
    {
        $authUser = User::where('slack_token', $slackUser->token)->first();
        if ($authUser) return $authUser;

        return User::create([
                'name'          => $slackUser->name,
                'slack_token'   => $slackUser->token,
                'slack_user_id' => $slackUser->id,
                'avatar'        => $slackUser['user']['image_512'],
                'sns'           => 'slack',
        ]);
    }

    public function logout ()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function __construct ()
    {
        $this->middleware('guest')->except('logout');
    }

}
