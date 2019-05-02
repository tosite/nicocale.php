<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $user = \App\User::first();
        if (empty($user)) {
            echo "先にユーザー登録を行ってください。\n";
            exit();
        }

        if (!empty(\App\Emotion::first())) {
            echo "一度DBをロールバックしてください。\n`php artisan migrate:reset && php artisan migrate`\n";
            exit();
        }

        echo "処理開始\n";

        \Auth::login($user);

        $teamUser = \App\TeamUser::me()->first();

        // joined sub teams
        $joinedSubTeams = [];
        for($cnt = 1; $cnt <= 3; $cnt++){
            $joinedSubTeams[] = \App\SubTeam::create([
                'team_id' => $teamUser->team_id,
                'bio'     => 'fugafuga',
                'name'    => "joined-{$cnt}"
            ]);
            \App\SubTeamUser::create([
                'user_id'     => $teamUser->user_id,
                'team_id'     => $teamUser->team_id,
                'team_user_id'=> $teamUser->id,
                'sub_team_id' => $joinedSubTeams[$cnt - 1]->id,
            ]);
        }

        // not joined sub teams
        $notJoinedSubTeams = [];
        for($cnt = 1; $cnt <= 3; $cnt++){
            $notJoinedSubTeams[] = \App\SubTeam::create([
                'team_id' => $teamUser->team_id,
                'bio'     => 'piyopiyo',
                'name'    => "not-joined-{$cnt}"
            ]);
        }

        // users
        $otherUsers = [];
        for($cnt = 1; $cnt <= 10; $cnt++){
            $otherUsers[] = \App\User::create([
                'name'          => "user-{$cnt}",
                'slack_token'   => "slack-token-{$cnt}",
                'slack_user_id' => "slack-user-id-{$cnt}",
                'bio'           => 'hogehoge',
                'avatar'        => 'https://nekogazou.com/wp-content/uploads/2015/03/gazou12-e1426694824704.jpg',
            ]);
        }
        // team user
        foreach($otherUsers as $u){
            // team users
            $tu = \App\TeamUser::create([
                'user_id' => $u->id,
                'team_id' => $teamUser->team_id,
            ]);

            // sub team users
            foreach($joinedSubTeams as $t) {
                \App\SubTeamUser::create([
                    'user_id'     => $tu->user_id,
                    'team_id'     => $tu->team_id,
                    'team_user_id'=> $tu->id,
                    'sub_team_id' => $t->id,
                ]);
            }
            foreach($notJoinedSubTeams as $t) {
                \App\SubTeamUser::create([
                    'user_id'     => $tu->user_id,
                    'team_id'     => $tu->team_id,
                    'team_user_id'=> $tu->id,
                    'sub_team_id' => $t->id,
                ]);
            }
        }

        // emotions
        $emojis = [':smile:', ':thinking_face:', ':fearful:', ':cry:', ':grin:'];
        foreach(\App\TeamUser::teamId($teamUser->team_id)->get() as $u) {
            $date = new \DateTime(date('Y-m-d', strtotime('-2 month')));
            for ($i = 0; $i < 90; $i++, $date->modify('+1 days')) {
                // others emotions
                \App\Emotion::create([
                    'team_user_id' => $u->id,
                    'entered_on' => $date->format('Y-m-d'),
                    'user_id' => $u->user_id,
                    'team_id' => $u->team_id,
                    'emoji' => $emojis[mt_rand(0, 4)],
                    'status_text' => 'hogehoge',
                    'memo' => 'fugafuga',
                ]);
            }
        }

        echo "処理終了\n";
    }
}
