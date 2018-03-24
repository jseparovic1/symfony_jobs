<?php

namespace Deployer;

require_once 'recipe/common.php';
require 'recipe/slack.php';

set('slack_webhook', 'https://hooks.slack.com/services/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');
set('slack_color', '#42f448');

set('repository', 'git@github.com:jseparovic1/symfony_jobs.git');
set('keep_releases', 2);
set('shared_dirs', ['config/jwt', 'public/logos']);
set('shared_files', ['.env']);
set('writable_dirs', ['var']);
set('allow_anonymous_stats', false);


//Premisions
set('writable_mode', 'chown');
set('http_group', 'www-data');
set('http_user', 'www-data');

set('application', 'api.symfonyjobs');
//set('git_tty', true);
set('branch', 'development');
set('default_stage', 'dev');
set('symfony_env', 'prod');

set('env',[
    'APP_ENV' => get('symfony_env')
]);

set('release_name', function () {
    return date('Y-m-d-His');
});

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
    ->set('deploy_path', '/var/www/api.symfonyjobs.io')
    ->forwardAgent(true)
    ->identityFile('~/.ssh/id_rsa')
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
;

task('deploy:copy:env', function () {
    run('cp {{release_path}}/.env.dist .env');
});

task('reload:services', function () {
    run('sudo /usr/sbin/service php7.2-fpm reload');
    run('service nginx restart');
});

task('deploy:cache:clear', function () {
    run('{{bin/php}} {{bin/console}} cache:clear {{console_options}} --no-warmup');
})->desc('Clear cache');

task('deploy:cache:warmup', function () {
    run('{{bin/php}} {{bin/console}} {{console_options}} cache:warmup');
})->desc('Warm up cache');

task('deploy:own', function () {
    run('sudo chown -R {{http_user}}:{{http_group}} {{deploy_path}}');
})->desc('Change ownership to www-data');

task('deploy:symlink:env', function () {
    run('sudo ln -s {{deploy_path}}/shared/.env {{deploy_path}}/current');
})->desc('Change ownership to www-data');

task('database:update', function () {
    run('{{bin/php}} {{bin/console}} do:sc:up {{console_options}} --allow-no-migration');
})->desc('Migrate database');

task('fix:var:permissions', function () {
    run('sudo chmod 777 -R {{release_path}}/var/log');
    run('sudo chmod 777 -R {{release_path}}/var/cache');
});

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:copy:env',
    'deploy:shared',
    'deploy:vendors',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:own',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

after('deploy', 'fix:var:permissions');
after('deploy', 'database:update');
after('deploy', 'reload:services');
after('deploy', 'success');
after('deploy:failed', 'deploy:unlock');
after('success', 'slack:notify:success');
after('deploy:failed', 'slack:notify:failure');
