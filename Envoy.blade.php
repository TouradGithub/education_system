@servers(['web' => 'u334693063@154.56.33.183 -p65002'])

@setup
    echo "Connecting to server";
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
@endsetup

@story('deploy')
    @check_directory
    @clone_repository
    @run_composer
    @setup_app
@endstory

@task('check_directory')
    echo "Checking if the directory exists or if we need to clone the repository."
    if [ ! -d "$new_release_dir/.git" ]; then
        echo "Directory is empty. Cloning repository."
        @clone_repository
    else
        echo "Directory is not empty. Pulling latest changes."
        @pull_repository
    fi
@endtask

@task('clone_repository')
    echo "Cloning the repository."
    git clone --depth 1 --branch {{ $branch }} {{ $repository }} {{ $new_release_dir }}
@endtask

@task('pull_repository')
    echo "Pulling the latest changes."
    cd {{ $new_release_dir }}
    git pull origin {{ $branch }}
@endtask

@task('run_composer')
    echo "Running Composer install."
    cd {{ $new_release_dir }}
    composer install --no-interaction --prefer-dist --optimize-autoloader
@endtask

@task('setup_app')
    echo "Setting up the application."
    cd {{ $new_release_dir }}
    cp .env.example .env
    php artisan key:generate --force
    php artisan migrate:fresh --force --seed
    php artisan optimize
    php artisan storage:link
@endtask
