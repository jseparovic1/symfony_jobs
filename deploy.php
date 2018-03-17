<?php

namespace Deployer;

require_once 'recipe/common.php';

set('repository', 'https://github.com/jseparovic1/symfony_jobs.git');
set('keep_releases', 2);
set('shared_dirs', ['var/log', 'config/jwt']);
set('shared_files', ['.env']);
set('writable_dirs', ['var']);
set('writable_use_sudo', true);
set('allow_anonymous_stats', false);

//Sudo ?
//set('cleanup_use_sudo', true);
//set('writable_use_sudo', true);

//Premisions
set('writable_mode', 'chown');
set('http_group', 'www-data');
set('http_user', 'www-data');

set('application', 'api.symfonyjobs');
set('git_tty', true);
set('branch', 'deployment');
set('default_stage', 'dev');
set('symfony_env', 'prod');

set('env',[
    'APP_ENV' => get('symfony_env')
]);

set('console_options', function () {
    $options = '--no-interaction --env={{symfony_env}}';
    return get('symfony_env') !== 'prod' ? $options : sprintf('%s --no-debug', $options);
});

set('bin/console', function () {
    return parse('{{bin/php}} {{release_path}}/bin/console --no-interaction');
});

host('api.symfonyjobs.io')
    ->stage('dev')
    ->port(22)
    ->user('root')
    ->set('deploy_path', '/var/www/api.symfonyjobs.com')
    ->multiplexing(true)
;

//task('deploy:setup:agent', function () {
//    run('echo "$SSH_PRIVATE_KEY" | ssh-add -');
//    run('eval $(ssh-agent)');
//    run('mkdir -p ~/.ssh');
//    run(' echo -e "StrictHostKeyChecking no" >> ~/.ssh/config');
//});

task('deploy:copy:env', function () {
    run('cp {{release_path}}/.env.dist .env');
});

task('reload:php-fpm', function () {
    run('sudo /usr/sbin/service php7.2-fpm reload');
});

task('deploy:cache:clear', function () {
    run('{{bin/php}} {{bin/console}} cache:clear {{console_options}} --no-warmup');
})->desc('Clear cache');

task('deploy:cache:warmup', function () {
    run('{{bin/php}} {{bin/console}} {{console_options}} cache:warmup');
})->desc('Warm up cache');

task('deploy:own', function () {
    run('sudo chown -R {{http_user}}:{{http_group}} {{release_path}}');
})->desc('Change ownership to www-data');

task('deploy:symlink:env', function () {
    run('sudo ln -s {{deploy_path}}/shared/.env {{deploy_path}}/current');
})->desc('Change ownership to www-data');

task('database:update', function () {
    run('{{bin/php}} {{bin/console}} do:sc:up {{console_options}} --allow-no-migration');
})->desc('Migrate database');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:copy:env',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:own',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

after('deploy', 'success');
after('deploy', 'database:update');
after('deploy', 'reload:php-fpm');
