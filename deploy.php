<?php
// $ php ./vendor/bin/dep deploy production

namespace Deployer;

require 'recipe/laravel.php';
with(\Dotenv\Dotenv::create(__DIR__)->load());

set('application', env('APP_NAME'));
set('repository', 'git@github.com:tosite0345/nicocale.php.git');
set('branch', 'master');
set('git_tty', false);
set('http_user', 'www-data');
set('writable_mode', 'chmod');

add('shared_files', ['.env']);
add('shared_dirs', []);
add('writable_dirs', ['bootstrap/cache', 'storage']);

host(env('DEPLOYER_MC_HOST'))
    ->stage('production')
    ->user(env('DEPLOYER_MC_USER'))
    ->port(env('DEPLOYER_MC_PORT'))
    ->identityFile('~/.ssh/id_rsa')
    ->set('deploy_path', env('DEPLOYER_MC_PATH'));

task('build', function () {
    run('cd {{release_path}} && build');
});

task('upload:env', function () {
    upload('.env.prod', '{{deploy_path}}/shared/.env');
})->desc('.envをアップロード');

task('upload:key', function () {
    upload('storage/oauth-private.key', '{{deploy_path}}/current/storage/oauth-private.key');
    upload('storage/oauth-public.key', '{{deploy_path}}/current/storage/oauth-public.key');
})->desc('.keyをアップロード');

task('deploy:notify:success', function () {
    slack_notify('success');
})->desc('デプロイ成功時に通知');

task('deploy:notify:failed', function () {
    slack_notify('failed');
})->desc('デプロイ失敗時に通知');

after('deploy:failed', 'deploy:unlock');
after('deploy:failed', 'deploy:notify:failed');

before('deploy:shared', 'upload:env');
before('deploy:symlink', 'upload:key');
before('deploy:symlink', 'artisan:migrate');

after('cleanup', 'deploy:notify:success');

function slack_notify($result)
{
    $message = ["attachments" => [[
        "color" => ($result == 'success') ? 'good' : 'danger',
        "text" => ($result == 'success') ? 'デプロイしたよ〜' : 'デプロイに失敗したよ〜',
    ]]];
    $message_encode = 'payload=' . urlencode(json_encode($message));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, env("LOG_SLACK_WEBHOOK_URL"));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $message_encode);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}