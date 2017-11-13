<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'carcar-web');

// Project repository
set('repository', 'https://github.com/rjcorflo/carcar-web.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);
set('keep_releases', 3);
set('ssh_multiplexing', false);

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', [
    'app/config/extensions',
    'app/database',
    'public/files',
    'public/thumbs'
]);

// Writable dirs by web server 
set('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
// Hosts
host('solus-dev')
    ->hostname('solus')
    ->stage('production')
    ->roles('app')
    ->set('deploy_path', '~/applications/{{application}}')
    ->set('branch', 'development')
    ->configFile('~/.ssh/config');

desc('Prepare configuration file');
task('bolt:config', function() {
    run('cp ~/applications/{{application}}/config_local.yml {{release_path}}/app/config/config_local.yml');
});

// Tasks
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'bolt:config',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
