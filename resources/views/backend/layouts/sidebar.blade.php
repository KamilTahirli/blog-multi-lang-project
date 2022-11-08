        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-crown"></i>
                </div>
                @if(Auth::user()->rank == 1)
                <div class="sidebar-brand-text">{{ __('translate.admin_panel') }}</div>
                @else
                <div class="sidebar-brand-text">{{ __('translate.moder_panel') }}</div>
                @endif
            </a>


            <!-- Divider -->
            <hr class="sidebar-divider">


             @if(Auth::user()->rank == 1)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('categories.index') }}">
                    <i class="fa fa-folder"></i>
                    <span>{{ __('translate.kateqoriyalar') }}</span>
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('posts.index') }}">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>{{ __('translate.postlar') }}</span>
                </a>
            </li>

            @if(Auth::user()->rank == 1)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('users.index') }}">
                    <i class="fa-solid fa-user"></i>
                    <span>{{ __('translate.istifadechiler') }}</span>
                </a>
            </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider">

          
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('users.profile') }}">
                    <i class="fa-regular fa-address-card"></i>
                    <span>{{ __('translate.profilim') }}</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

        </ul>
