
  <!-- Show Sidebar Button -->
  <a id="show-sidebar" class="btn" href="#">
    <i class="fas fa-bars"></i>
  </a>

  <!-- Sidebar -->
  <nav class="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">

      <!-- Sidebar brand  -->
      <div class="sidebar-brand p-2">
        <a href="{{ route('superadmin-home') }}">UP | Administration</a>
        <div id="close-sidebar">
          <i class="fas fa-times mr-2"></i>
        </div>
      </div> <!-- Sidebar brand End  -->

      <!-- Sidebar header  -->
      <div class="sidebar-header p-3">
        <div class="admin-pic">
          <img class="img-responsive img-rounded" src="/storage/avatars/{{ $user->image }}"
            alt="Administrator Image">
        </div>
        <div class="admin-info">
          <span class="admin-name">{{ ucfirst($user->name) }}
            <strong>{{ ucfirst($user->lastname) }}</strong>
          </span>
          <span class="admin-role">{{ ($user->role === 'superadmin') ? 'Superadministrator' : 'Administrator' }}</span>
        </div>
      </div><!-- Sidebar header End  -->

      <!-- Sidebar Menu  -->
      <div class="sidebar-menu">
        <ul>
          <li class="{{ Route::is('superadmin-home') ? 'isActive' : '' }}">
            <a href="{{ route('superadmin-home') }}">
              <i class="fa fa-tachometer-alt mr-2 p-2"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="{{ Route::is('superadmin-categories') ? 'isActive' : '' }}">
            <a href="{{ route('superadmin-categories') }}">
              <i class="fas fa-cubes mr-2 p-2"></i>
              <span>Categories</span>
            </a>
          </li>
          <li class="{{ Route::is('superadmin-mot-msgs') ? 'isActive' : '' }}">
            <a href="{{ route('superadmin-mot-msgs') }}">
              <i class="fas fa-gem mr-2 p-2"></i>
              <span>Motivation Messages</span>
            </a>
          </li>
          <li class="sidebar-dropdown {{ Route::is('superadmin-cont-msgs') ? 'isActive' : '' }} {{ Route::is('deleted-cont-msgs') ? 'isActive' : '' }}">
            <a href="#">
              <i class="fas fa-comment-alt mr-2 p-2"></i>
              <span>Contact Messages</span>
              @if ($contactMsgs > 0)
                  <span class="badge badge-pill badge-warning float-right mt-1 mr-1">{{ $contactMsgs }}</span>
              @endif
            </a>
            <div class="sidebar-submenu">
              <ul class="pl-5">
                <li class="{{ Route::is('superadmin-cont-msgs') ? 'isActive' : '' }}">
                  <a href="{{ route('superadmin-cont-msgs') }}">Messages
                    @if ($contactMsgs > 0)
                        <span class="badge badge-pill badge-warning float-right mt-1 mr-1">{{ $contactMsgs }}</span>
                    @endif
                  </a>
                </li>
                <li class="{{ Route::is('deleted-cont-msgs') ? 'isActive' : '' }}">
                  <a href="{{ route('deleted-cont-msgs') }}">Deleted Messages</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown {{ Route::is('superadmin-coaches') ? 'isActive' : '' }} {{ Route::is('superadmin-users') ? 'isActive' : '' }} {{ Route::is('superadmin-banned') ? 'isActive' : '' }}">
            <a href="#">
              <i class="fas fa-users mr-2 p-2"></i>
              <span>Users</span>
            </a>
            <div class="sidebar-submenu">
              <ul class="pl-5">
                <li class="{{ Route::is('superadmin-coaches') ? 'isActive' : '' }}">
                  <a href="{{ route('superadmin-coaches') }}">Verified Coaches</a>
                </li>
                <li class="{{ Route::is('superadmin-users') ? 'isActive' : '' }}">
                  <a href="{{ route('superadmin-users') }}">Regular Users</a>
                </li>
                <li class="{{ Route::is('superadmin-banned') ? 'isActive' : '' }}">
                  <a href="{{ route('superadmin-banned') }}">Banned Users</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown {{ Route::is('superadmin-relations') ? 'isActive' : '' }} {{ Route::is('superadmin-active-relations') ? 'isActive' : '' }}">
            <a href="#">
                <i class="fas fa-exchange-alt mr-2 p-2"></i>
              <span>Relations</span>
            </a>
            <div class="sidebar-submenu">
              <ul class="pl-5">
                <li class="{{ Route::is('superadmin-relations') ? 'isActive' : '' }}">
                  <a href="{{ route('superadmin-relations') }}">All Relations</a>
                </li>
                <li class="{{ Route::is('superadmin-active-relations') ? 'isActive' : '' }}">
                  <a href="{{ route('superadmin-active-relations') }}">Active Relations</a>
                </li>
              </ul>
            </div>
          </li>

          @if (Auth::check() && Auth::user()->role !== 'superadmin')
              <li class="mt-3">
                  <a href="{{ route('coach-home') }}">
                      <i class="fas fa-undo mr-2 p-2"></i>
                      <span> Back To App</span>
                  </a>
              </li>
          @else
              <li class="mt-3 {{ Route::is('superadmin-password') ? 'isActive' : '' }}">
                  <a href="{{ route('superadmin-password') }}">
                    <i class="fas fa-unlock mr-2 p-2"></i>
                      <span> Change Password</span>
                  </a>
              </li>
          @endif

          <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off mr-2 p-2"></i>
                <span>{{ __('Logout') }}</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>

        </ul>
      </div><!-- sidebar-menu End  -->

    </div> <!-- Sidebar Content End -->
  </nav> <!-- Sidebar End -->

