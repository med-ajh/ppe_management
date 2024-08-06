<head>
    <!-- Add Font Awesome CDN link in your <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
      /* Sidebar styling */
      #sidenav-main {
        background-color: #ffffff; /* White background for the sidebar */
        color: #000000; /* Default text color */
      }

      /* Default icon color */
      .nav-link .icon i {
        color: #6c757d; /* Adjust color as needed (e.g., gray) */
      }
      /* Icon color when active */
      .nav-link.active .icon i {
        color: #ffffff; /* White color for active state */
      }
      /* Border color when active */
      .nav-link.active .icon {
        border-color: #fd7e14; /* Orange color for the border when active */
      }

      /* Optional: Change text color on active link */
      .nav-link.active {
        color: #fd7e14; /* Optional: Color for the active link text */
      }

      /* Optional: Sidebar header styling */
      .sidenav-header {
        background-color: #ffffff; /* White background for the header */
      }
    </style>
  </head>
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
      <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('home') }}">
          <img src="../assets/img/logo.png" class="navbar-brand-img h-100" alt="...">
        </a>
      </div>
      <hr class="horizontal dark mt-0">
      <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

          <!-- Dynamic Dashboard Button -->
          <li class="nav-item">
            @php
              $route = Auth::user()->role === 'admin' ? 'admin.dashboard' : (Auth::user()->role === 'manager' ? 'manager.dashboard' : 'employee.dashboard');
            @endphp
            <a class="nav-link {{ (Request::is('*dashboard*') ? 'active' : '') }}" href="{{ route($route) }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-tachometer-alt"></i>
              </div>
              <span class="nav-link-text ms-1">Dashboard</span>
            </a>
          </li>

          <!-- Profile Management -->
          <li class="nav-item">
            <a class="nav-link {{ (Request::is('profile') ? 'active' : '') }}" href="{{ url('profile') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-user"></i>
              </div>
              <span class="nav-link-text ms-1">Profile</span>
            </a>
          </li>
          @if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager')

          <br>
          <li class="nav-item mt-2">

              <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Users Management</h6>
              @endif
          </li>
          <li class="nav-item">
            @if (Auth::user()->role === 'admin')
              <a class="nav-link {{ (Request::is('users') ? 'active' : '') }}" href="{{ url('users') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fas fa-users"></i>
                </div>
                <span class="nav-link-text ms-1">Users</span>
              </a>
            @endif
          </li>

          <li class="nav-item">
            @if (Auth::user()->role === 'admin')

              <a class="nav-link {{ (Request::is('managers') ? 'active' : '') }}" href="{{ url('managers') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fas fa-user-tie"></i>
                </div>
                <span class="nav-link-text ms-1">Managers</span>
              </a>
              @endif
            </li>

            <li class="nav-item">
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager')
                  <a class="nav-link {{ (Request::is(Auth::user()->role === 'admin' ? 'employees' : 'manager/employees') ? 'active' : '') }}" href="{{ Auth::user()->role === 'admin' ? url('employees') : url('manager/employees') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="fas fa-briefcase"></i>
                    </div>
                    <span class="nav-link-text ms-1">Employees</span>
                  </a>
                @endif
              </li>

              @if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager')


              <br>

              <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Inventory Management</h6>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ (Request::is('items') ? 'active' : '') }}" href="{{ url('items') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-box"></i>
                  </div>
                  <span class="nav-link-text ms-1">Items</span>
                </a>
              </li>
                @endif

              <br>
              <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Request Management</h6>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ (Request::is('requests/create') ? 'active' : '') }}" href="{{ url('requests/create') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-plus"></i>
                  </div>
                  <span class="nav-link-text ms-1">Make a Request</span>
                </a>
              </li>

              @if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager')
              <li class="nav-item">
                <a class="nav-link {{ (Request::is('requests/approve') ? 'active' : '') }}" href="{{ url('requests/approve') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-check-circle"></i>
                  </div>
                  <span class="nav-link-text ms-1">Approve Requests</span>
                </a>
              </li>
            @endif

              <li class="nav-item">
                <a class="nav-link {{ (Request::is('requests') ? 'active' : '') }}" href="{{ url('requests') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-clipboard-list"></i>
                  </div>
                  <span class="nav-link-text ms-1">Follow My Requests</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ (Request::is('history') ? 'active' : '') }}" href="{{ url('history') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-history"></i>
                  </div>
                  <span class="nav-link-text ms-1">History</span>
                </a>
              </li>

              <br>
              <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">TE Management</h6>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ (Request::is('departments') ? 'active' : '') }}" href="{{ url('departments') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-building"></i>
                  </div>
                  <span class="nav-link-text ms-1">Departments</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ (Request::is('cost-centers') ? 'active' : '') }}" href="{{ url('cost-centers') }}">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-cogs"></i>
                  </div>
                  <span class="nav-link-text ms-1">Cost Centers</span>
                </a>
              </li>

        </ul>
      </div>
  </aside>
