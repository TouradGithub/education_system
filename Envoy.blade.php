@servers(['web' => 'u334693063@154.56.33.183 -p65002'])

@setup
echo "Connect to server";
$repository = 'git@github.com:TouradGithub/edication_system.git';
$branch = isset($branch) ? $branch : "main";
$app_dir = "u334693063";
$releases_dir = "$app_dir/releases";
$release = date('YmdHis');
$new_release_dir = "$releases_dir/$release";
$branch_path = "$app_dir/$branch";
$env_file_name = ".env.$branch";
$env_path = "$branch_path/$env_file_name";
echo '{{$env_path}}';
$keep = 1;
$new_release_dir = "/home/u334693063/domains/edzayer.com/public_html/test_system";
@endsetup
$server_dir = $branch;

@story('deploy')
    @task('check_directory')
        # Check if the directory is empty
        echo 'Checking if the directory is empty'
        if [ ! -d "$new_release_dir/.git" ]; then
            echo 'Directory is empty, cloning repository.'
            php artisan down
            @clone_repository
            @run_composer
            @setup_app
            php artisan up
        else
            echo 'Directory is not empty, pulling the latest changes.'
            @pull_repository
            @run_composer
            @setup_app
        fi
    @endtask
@endstory

@task('clone_repository')
    echo 'Cloning repository'
    git clone --depth 1 --branch {{ $branch }} {{ $repository }} {{ $new_release_dir }}
    cd {{ $new_release_dir }}
@endtask

@task('pull_repository')
    echo 'Pulling latest changes'
    cd {{ $new_release_dir }}
    git fetch --all
    git checkout {{ $branch }}
    git pull origin {{ $branch }}
@endtask

@task('run_composer')
    echo 'Starting deployment ({{ $release }})'
    cd {{ $new_release_dir }}
    echo 'Running composer install'
    composer install --no-interaction --prefer-dist --optimize-autoloader
@endtask

@task('setup_app')
    echo 'Setting up the app'
    cd {{ $new_release_dir }}
    cp .env.example .env
    php artisan key:generate --force
    php artisan optimize:clear

    php artisan optimize
    php artisan view:clear
    php artisan storage:link
@endtask

@task('clean')
    echo 'Cleaning old releases'
    cd {{ $releases_dir }}
    echo 'We will keep only the last {{ $keep }} releases and will remove the rest.'
    rm -rf $(ls -t | tail -n +{{ $keep + 1 }})
@endtask

@task('succeed')
    echo 'Deployment completed successfully. The new {{$branch}} release {{$release}} is live now.'
@endtask
