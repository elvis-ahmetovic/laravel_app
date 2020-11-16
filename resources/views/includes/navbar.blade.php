<nav class="navbar navbar-expand-lg fixed-top">
    <a class="navbar-brand ml-lg-5 mb-3" href="{{ route('index') }}">
        {{ config('app.name', 'Laravel') }} <span>- be best version of yourself</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto nav-links mb-2 mb-lg-0">
            @guest
                <li class="nav-item">
                    <a class="nav-link pl-2 ml-lg-5" href="{{ route('show') }}">{{ __('Contact') }}</a>
                </li>
            @else
                <!-- If user's role in coach -->
                @if (Auth::check() && $user->role === 'coach')
                    <li class="nav-item">
                        <a class="nav-link ml-lg-2" href="{{ route('show-finish-registration') }}">
                            {{ __('Finish Registration') }}
                        </a>
                    </li>
                @endif
            @endguest
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto nav-links">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link pl-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>

                @if (Route::has('register'))
                    <li class="nav-item mr-lg-5">
                        <a class="nav-link pl-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                
                <!-- If user's role in verified_coach -->
                @if($user->role === 'verified_coach' || $user->role === 'user')
                    <li class="nav-item">
                        <a class="nav-link pl-2 ml-lg-5" href="{{ route('index') }}">{{ __('Index') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ (Auth::check() && Auth::user()->role === 'user') ? route('user-home') : route('coach-home') }}">
                            {{ __('Home') }}
                            <!-- If coach have new Relation requests -->
                            @if(count($relation) > 0)
                                <span class="badge relation">{{ count($relation) }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('show') }}">{{ __('Contact') }}</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('private-messages') }}" class="nav-link">
                            {{ __('Messages') }}
                            @if(($new_messages > 0) && (count($replys) > 0))
                                <span class="badge messages">{{ $new_messages }}</span>
                                <span class="badge messages">{{ count($replys) }}</span>
                            @elseif($new_messages > 0)
                                <span class="badge messages">{{ $new_messages }}</span>
                            @elseif(count($replys) > 0)
                                <span class="badge messages">{{ count($replys) }}</span>
                            @endif
                        </a>
                    </li>
                @endif

                
                
                <!-- Dropdown list item -->
                <li class="nav-item dropdown">
                    
                    <a id="navbarDropdown" class="nav-link dropdown-toggle ml-lg-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img class="rounded-circle" src="/storage/avatars/{{ $user->image }}"
                                 alt="Avatar Image">
                        {{ ucfirst($user->name) }}
                    </a>

                    <!-- Dropdown menu -->
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <!-- If user's role in coach -->
                        @if (Auth::check() && $user->role === 'coach')
                            <a class="dropdown-item" href="{{ route('show-finish-registration') }}">
                                {{ __('Finish Registration') }}
                            </a>
                        <!-- For other users -->
                        @else
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                {{ __('My Profile') }}
                            </a>
                        @endif

                        <!-- If user's admin status is 1 (active) -->
                        @if (Auth::check() && $user->admin_status === 1)
                            <a class="dropdown-item" href="{{ route('superadmin-home') }}">
                                {{ __('Administration') }}
                            </a>
                        @endif
                        
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div> <!-- Dropdown menu END -->
                </li> <!-- Dropdown list item END -->
            @endguest
        </ul>
    </div>
</nav>