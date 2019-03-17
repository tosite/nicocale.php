<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \App\User::truncate();
        \App\Team::truncate();
        \App\TeamUser::truncate();
        \App\Emotion::truncate();

        factory(App\User::class, 10)->create();
        echo "users end.";
        factory(App\Team::class, 5)->create();
        echo "teams end.";

        $users = \App\User::all();
        $teams = \App\Team::all();

        foreach ($teams as $team) {
            foreach ($users as $user) {
                \App\TeamUser::create([
                    'user_id' => $user->id,
                    'team_id' => $team->id,
                ]);
            }
        }
        echo "team-users end.";

        $user = \App\User::first();
        $teamUser = \App\TeamUser::userId($user->id)->first();
        $subTeam = \App\SubTeam::create([
            'name' => 'hoge',
            'avatar' => '',
            'team_id' => $teamUser->team_id,
        ]);
        echo "sub-team-users end.";

        \App\SubTeamUser::create([
            'user_id' => $teamUser->user_id,
            'team_id' => $teamUser->team_id,
            'team_user_id' => $teamUser->id,
            'sub_team_id' => $subTeam->id,
        ]);

        $emojis = ['😀', '😐', '😇', '😵', '😡'];
        foreach (\App\TeamUser::get() as $team_user) {
            $date = new \DateTime(date('Y-m-d', strtotime('-3 month')));
            for ($i = 0; $i < 90; $i++, $date->modify('+1 days')) {
                \App\Emotion::create([
                    'team_user_id' => $team_user->id,
                    'entered_on' => $date->format('Y-m-d'),
                    'user_id' => $team_user->user->id,
                    'team_id' => $team_user->team->id,
                    'emoji' => $emojis[mt_rand(0, 4)],
                    'status_text' => $faker->sentence,
                    'memo' => $faker->sentence,
                ]);
            }
        }

    }
}
