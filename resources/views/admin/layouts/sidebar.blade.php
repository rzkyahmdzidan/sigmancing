<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-fish"></i>
        <h2>SigMancing</h2>
        <button id="close-sidebar" class="btn d-md-none">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="mt-4">
        <div class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.spot.index') }}"
                class="nav-link {{ request()->routeIs('admin.spot.*') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i>
                <span>Kelola Spot</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.toko.index') }}"
                class="nav-link {{ request()->routeIs('admin.toko.*') ? 'active' : '' }}">
                <i class="fas fa-store"></i>
                <span>Kelola Toko</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.umpan.index') }}"
                class="nav-link {{ request()->routeIs('admin.umpan.*') ? 'active' : '' }}">
                <i class="fas fa-worm"></i>
                <span>Rekomendasi Umpan</span>
            </a>
        </div>
    </nav>
</div>
