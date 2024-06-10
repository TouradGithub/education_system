
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ URL::to('/school/home') }}"> <img src="{{ env('LOGO1') ? url(Storage::url(env('LOGO1'))) : url('assets/logo.svg') }}" alt="logo"> </a> <a class="navbar-brand brand-logo-mini" href="{{ URL::to('/') }}"> <img src="{{ url('assets/logo.svg') }}" alt="logo"> </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="fa fa-bars"></span>
        </button>



        <ul class="navbar-nav navbar-nav-right">

            @if (Auth::user())

            @endif
            <li class="nav-item nav-profile dropdown" id="notifications_count">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-bell menu-icon"></i>
                    @if (Auth::user()->unreadNotifications->count()>0)
                    <strong class="text-danger">{{Auth::user()->unreadNotifications->count()}}</strong>
                    @endif
                </a>
                </a>

                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

                    @forelse (Auth::user()->unreadNotifications as $notification)
                        <a class="dropdown-item" href="{{route('school.get-notification', $notification->id )}}">
                            <i class="fa fa-user mr-2"></i>
                            {{ $notification->data['title'] }}
                        </a>
                    @empty

                        <h4>No Notification</h4>

                    @endforelse

                </div>



            </li>

            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-language"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a class="dropdown-item preview-item" href="
                    {{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}
                                       ">
                                           <div class="preview-thumbnail">
                                               {{-- <img src="../../../assets/images/faces/face3.jpg" alt="image" class="profile-pic"> --}}
                                           </div>
                                           <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                               <h6 class="preview-subject ellipsis mb-1 font-weight-normal">{{ $properties['name'] }}
                                                   {{-- {{$language->name}} --}}
                                               </h6>
                                               {{-- <p class="text-gray mb-0"> 18 Minutes ago </p> --}}
                                           </div>
                                       </a>
                                       <div class="dropdown-divider"></div>
                    @endforeach
                </div>
            </li>

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="true">
                    <div class="nav-profile-img">
                        <img src="{{url(Auth::user()->image)}}" alt="image" onerror="onErrorImage(event)">
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">
                            {{ Auth::user()->name }}
                        </p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    {{-- @can('update-admin-profile') --}}
                    <a class="dropdown-item" href="{{ route('school.edit-profile') }}">
                        <i class="fa fa-user mr-2"></i>{{ __('genirale.update_profile') }}</a>
                    <div class="dropdown-divider"></div>
                    {{-- @endcan --}}
                    <a class="dropdown-item" href="
                    {{ route('school.resetpassword') }}
                    ">
                        <i class="fa fa-refresh mr-2 text-success"></i>{{ __('genirale.change_password') }}</a>
                    <div class="dropdown-divider"></div>
                    <a
                        class="dropdown-item"
                        href="{{ route('web.logout') }}"
                    >
                        <i class="fa fa-sign-out mr-2 text-primary"></i> {{ __('genirale.signout') }}
                    </a>
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="fa fa-bars"></span>
        </button>
    </div>
</nav>
