@servers(['web' => 'u334693063@154.56.33.183 -p65002'])

@setup
echo "Connect to server";
$repository = 'git@github.com:TouradGithub/edication_system.git';
$branch = isset($branch) ? $branch : "main";
$app_dir = "u334693063";

$release = date('YmdHis');

$branch_path = "$app_dir/$branch";
$env_file_name = ".env.$branch";
$env_path = "$branch_path/$env_file_name";
echo '{{$env_path}}';
$keep = 1;
$new_release_dir = "/home/u334693063/domains/edzayer.com/public_html/test_system";
$composer = "/home/u334693063/domains/edzayer.com/public_html/composer.json";
@endsetup
$server_dir = $branch;

@story('deploy')

echo "Checking if composer.json exists at $composer"

@if (file_exists($composer))
    echo "composer.json exists, pulling repository and running composer install."
    pull_repository
    run_composer
@else
    echo "composer.json not found, cloning repository."
    clone_repository
    setup_app
    succeed
@endif


@endstory

@task('clone_repository')
    echo 'Cloning repository'
    echo 'Cloning branch {{ $branch }} from repository {{ $repository }} into {{ $new_release_dir }}'

    # Ensure directory exists before cloning
    mkdir -p {{ $new_release_dir }}
    git clone --depth 1 --branch {{ $branch }} {{ $repository }} {{ $new_release_dir }}
    echo 'Cloning terminer'
@endtask

@task('pull_repository')
    echo 'Pulling latest changes.'
    cd {{ $new_release_dir }}
    pwd
    git add .
    git commit -m "update"
    git pull origin {{ $branch }}
    echo 'Pulling latest changes Terminate.'
@endtask

@task('run_composer')
    echo "Running Composer install."
    cd {{ $new_release_dir }}
    composer install --no-interaction --prefer-dist --optimize-autoloader
    echo "Running Composer T"
@endtask

@task('setup_app')
    echo "Setting up the app"
    cd {{ $new_release_dir }}
    pwd
    free -g -h -t && sync && free -g -h
    echo "Run migrate"
    cp .env.example .env
    php artisan key:generate --force
    echo "Key generated"
    php artisan optimize:clear
    echo "Optimized cleared"
    echo "Migration complete"
    php artisan optimize
    echo "Optimization complete"
    php artisan view:clear
    php artisan storage:link
    echo "View cleared and storage linked"
    free -h
@endtask

@task('succeed')
    free -g -h -t && sync && free -g -h -t
    echo 'Deployment completed successfully. The new {{$branch}} release {{$release}} is live now!'
@endtask

@php
// Function to check if the directory is a valid Git repository
function is_git_repository($dir) {
    $git_dir = $dir . '/.git';
    return is_dir($git_dir);
}
@endphp
