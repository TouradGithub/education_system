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
$composer = "/home/u334693063/domains/edzayer.com/public_html/test_system/composer.json";
@endsetup

$server_dir = $branch;

@story('deploy')


    @if (!is_dir($new_release_dir) || !is_git_repository($new_release_dir))

        clone_repository
        run_composer
        setup_app
    @else

        pull_repository
        run_composer

    @endif



@endstory

@task('check_composer')
    echo "Checking if composer.json exists at {{ $composer }}: {{ file_exists($composer) ? 'Exists' : 'Does not exist' }}"
@endtask

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
git config --global user.email "touradmedlemin17734@gmail.com"
git config --global user.name "Tourad"

if [[ `git status --porcelain` ]]; then
    echo "Changes detected, committing and pulling latest changes."
    git add .
    git commit -m "update"
    git pull origin {{ $branch }}
else
    echo "No changes detected, skipping commit and pull."
    git pull origin {{ $branch }}
fi
echo 'Pulling latest changes Terminate.'
@endtask

@task('run_composer')
    echo "Running Composer install."
    cd {{ $new_release_dir }}
    composer install --no-interaction --prefer-dist --optimize-autoloader
    echo "Composer install finished"
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
    $git_dir = $dir . '/.gitignore';
    return is_dir($git_dir);
}
@endphp
