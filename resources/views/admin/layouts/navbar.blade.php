<nav class="navbar">
    <div class="d-flex align-items-center">
        <button id="sidebar-toggle" class="btn">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="mb-0 ms-3 d-none d-sm-block">@yield('title', 'Dashboard')</h5>
    </div>
    <div class="user-profile">
        <div class="user-avatar">
            {{ substr(Auth::user()->name, 0, 2) }}
        </div>
        <div class="user-info">
            <div class="fw-bold">{{ Auth::user()->name }}</div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none">
                    <small><i class="fas fa-sign-out-alt"></i> Logout</small>
                </button>
            </form>
        </div>
        <div class="dropdown d-sm-none">
            <button class="btn" type="button" id="userMenuDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                <li><span class="dropdown-item-text fw-bold">{{ Auth::user()->name }}</span></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <!-- Tombol untuk menutup navbar -->
    <div class="navbar-toggle" id="navbar-toggle">
        <i class="fas fa-chevron-up"></i>
    </div>
</nav>
