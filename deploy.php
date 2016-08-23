<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/deployer/deployer/recipe/composer.php';

// Whether to use sudo or not during deployment
set("sudo_for_composer_is_wrong", true);

server('digitalocean', getenv('PRODUCTION_IP_ADDRESS'))
    ->user(getenv('DEPLOY_USER'))
    ->password(getenv('DEPLOY_PASSWORD'))
    //->identityFile()
    ->stage('production')
    ->env('deploy_path', getenv('DEPLOY_DIR'));

// The Git repository to use
// 'git@github.com:settermjd/laravel-codeship-deployment.git'
set('repository', getenv('REPOSITORY'));

// The number of old releases to retain, in addition to the current release
set('keep_releases', getenv('RELEASES'));

task('deploy:copy-env-file', function () {
    $deployPath = '/var/www/html/current';
    $envFile = '/opt/apps/config/.env';
    run("cp {$envFile} {$deployPath}");
})->desc("Copy the env file");

task('deploy:artisan-make', function () {
    $deployPath = env('/var/www/html/current');
    cd($deployPath);
    run("php artisan make");
})->desc("Run Artisan make");

// A custom task for when everything's finished.
task('deploy:done', function () {
    write('Deploy done!');
})->desc("When deployment's completed");

// The deployment pipeline
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:copy-env-file',
    'deploy:vendors',
    'deploy:artisan-make',
    'deploy:symlink',
    'cleanup'
])->desc("The main deployment process");

// The task to run after deployment
after('deploy', 'deploy:done');
