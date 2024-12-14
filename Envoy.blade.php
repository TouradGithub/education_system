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
@endsetup
$server_dir = $branch;

@story('deploy')
    @if (is_dir($new_release_dir) && count(array_diff(scandir($new_release_dir), array('.', '..'))) > 0 && is_git_repository($new_release_dir))
        pull_repository
    @else
        clone_repository
    @endif

    run_composer
    setup_app
    succeed
@endstory

@task('clone_repository')
    echo 'Cloning repository'
    echo 'Cloning branch {{ $branch }} from repository {{ $repository }} into {{ $new_release_dir }}'

    # Ensure directory exists before cloning
    mkdir -p {{ $new_release_dir }}
    git clone --depth 1 --branch {{ $branch }} {{ $repository }} {{ $new_release_dir }}
@endtask

@task('pull_repository')
    echo 'Pulling latest changes.'
    cd {{ $new_release_dir }}
    pwd
    git pull origin {{ $branch }}
@endtask

@task('run_composer')
    echo "Running Composer install."
    cd {{ $new_release_dir }}
    composer install --no-interaction --prefer-dist --optimize-autoloader
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
