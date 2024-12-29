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

<?php
$composer = '/home/u334693063/domains/edzayer.com/public_html/test_system/composer.json';
echo file_exists($composer) ? 'Exists' : 'Does not exist';
?>

@story('deploy')
<<<<<<< HEAD
clone_repository
 run_composer
setup_app
clean
succeed
=======

check_composer


>>>>>>> main
@endstory

@task('check_composer')
    if [ -f "/home/u334693063/domains/edzayer.com/public_html/test_system/composer.json" ]; then
        echo "composer.json exists."
        echo 'Pulling latest changes.'
        cd {{ $new_release_dir }}
        pwd
        git config --global user.email "touradmedlemin17734@gmail.com"
        git config --global user.name "Tourad"

        # Configure Git to handle divergent branches
        git config pull.rebase false  # Change this as needed (merge, rebase, ff only)

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

        echo "Running Composer install."
        composer install --no-interaction --prefer-dist --optimize-autoloader
        echo "Composer install finished"
    else
        echo 'Cloning repository'
        echo 'Cloning branch {{ $branch }} from repository {{ $repository }} into {{ $new_release_dir }}'

        mkdir -p {{ $new_release_dir }}
        git clone --depth 1 --branch {{ $branch }} {{ $repository }} {{ $new_release_dir }}
        echo 'Cloning completed'

        echo "Running Composer install."
        cd {{ $new_release_dir }}
        composer install --no-interaction --prefer-dist --optimize-autoloader
        echo "Composer install finished"

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

        echo "Optimization complete"

<<<<<<< HEAD
@task('run_composer')
echo "Starting deployment ({{ $release }})"
pwd
echo {{ $new_release_dir }}
cd {{ $new_release_dir }}
echo "moved succes".{{ $new_release_dir }}
composer update
echo "composer installed  succefuly"
php composer.phar update
echo "composer.phar updated  succefuly"
php composer.phar install --no-interaction --prefer-dist --optimize-autoloader
php composer.phar dumpautoload
echo "composer installed  for ({{ $release }})"
=======
        echo "OK"
        echo "View cleared and storage linked"
        free -h
    fi
>>>>>>> main
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






@task('succeed')
    free -g -h -t && sync && free -g -h -t
    echo 'Deployment completed successfully. The new {{$branch}} release {{$release}} is live now!'
@endtask

@php
// Function to check if the dire
function is_git_repository($dir) {
    $git_dir = $dir . '/.gitignore';
    return is_dir($git_dir);
}
@endphp
