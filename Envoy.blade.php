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
$new_release_dir = "/home/u334693063/domains/edzayer.com/public_html/system_education";
@endsetup
$server_dir=$branch;


@story('deploy')
echo "good"
{{-- clone_repository --}}
 {{-- run_composer
setup_app --}}
{{--clean
succeed --}}
@endstory





@task('clone_repository')
free -g -h -t && sync && free -g -h
echo 'Cloning repository'
echo 'Cloning  branch {{ $branch }} from rep {{ $repository }} in {{ $new_release_dir }}'

{{-- mkdir -p "{{$new_release_dir}}" ; --}}
echo '  ok'
git clone --depth 1 --branch {{ $branch }} {{ $repository }} {{ $new_release_dir }}


cd {{ $new_release_dir }}
{{-- //git reset --hard {{ $commit }} --}}
@endtask

@task('run_composer')
echo "Starting deployment ({{ $release }})"
pwd
echo {{ $new_release_dir }}
cd {{ $new_release_dir }}
echo "moved succes".{{ $new_release_dir }}
{{-- composer update --}}
echo "composer installed  succefuly"
{{-- php composer.phar update
echo "composer.phar updated  succefuly"
php composer.phar install --no-interaction --prefer-dist --optimize-autoloader
php composer.phar dumpautoload
echo "composer installed  for ({{ $release }})" --}}
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
{{-- uU334693063$ --}}
