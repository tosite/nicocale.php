<?php
// $ php ./vendor/bin/dep deploy production

namespace Deployer;

require 'recipe/laravel.php';
with(new \Dotenv\Dotenv(__DIR__))->load();

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

after('deploy:failed', 'deploy:unlock');
before('deploy:shared','upload:env');
after('upload:env','upload:key');
before('deploy:symlink', 'artisan:migrate');
