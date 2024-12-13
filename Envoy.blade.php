@servers(['web' => 'u334693063@154.56.33.183 -p65002'])

@setup
echo "Connect to server";
$repository= 'git@github.com:TouradGithub/edication_system.git';
$branch = isset($branch) ? $branch : "main";
$app_dir = "u334693063";
$releases_dir = "$app_dir/releases";
$release = date('YmdHis');
$new_release_dir ="$releases_dir/$release";
$branch_path="$app_dir/$branch";
$env_file_name =".env.$branch";
$env_path="$branch_path/$env_file_name";
echo '{{$env_path}}';
$keep = 1;
$new_release_dir = "/home/u334693063/domains/edzayer.com/public_html/test_system";
@endsetup
$server_dir=$branch;


@story('deploy')
check_and_clone_or_pull
succeed
@endstory



@task('check_and_clone_or_pull')

    @if ($new_release_dir)
    @clone_repository

    @run_composer

    @setup_app
    @else
    @pull_repository
    @endif
@endtask

@task('clone_repository')

echo 'Cloning repository'
echo 'Cloning branch {{ $branch }} from repository {{ $repository }} into {{ $new_release_dir }}'
git clone --depth 1 --branch {{ $branch }} {{ $repository }} {{ $new_release_dir }}


@endtask

@task('pull_repository')
    echo 'Pulling latest changes.'
    cd {{ $new_release_dir }}
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
echo " test key ok"
php artisan optimize:clear
echo " test optimize ok"
php artisan migrate:fresh --force --seed
echo " test migrate ok"
php artisan optimize
echo " test optimize ok"
php artisan view:clear
php artisan storage:link
echo " test view ok"


free -h
echo " test free -h"

@endtask

{{-- Clean old releases --}}
@task('clean')
echo "Clean old releases";
cd {{ $releases_dir }};

echo "we will keep only last {{ $keep }} releases || and will remove >>  $(ls -t | tail -n +{{ $keep +1 }})";

rm -rf $(ls -t | tail -n +{{ $keep +1 }});
@endtask

@task('succeed')
free -g -h -t && sync && free -g -h -t
echo 'Deployment completed successfully. the new {{$branch}} releases {{$release}} is live now : '
@endtask


