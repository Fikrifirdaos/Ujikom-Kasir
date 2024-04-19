<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <!-- Brand Logo -->
        <div class="sidebar-brand">
            <a href="">Sopo.id</a>
        </div>
        <!-- Small Brand Logo -->
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">S</a>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <!-- User Management (for Administrator) -->
            @if (Auth::user()->hasRole('admin'))
                <li class="{{ Request::is('user*') ? 'active' : '' }}">
                    <a class="nav-link" href="">
                        <i class="fas fa-user"></i> <span>Akun Pengguna</span>
                    </a>
                </li>
            @endif
            <!-- Sales Management -->
            <li class="menu-header">Manajemen Penjualan</li>
            <!-- Penjualan -->
            <li class="{{ Request::is('penjualan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('penjualan')}}">
                    <i class="fas fa-money-bill"></i> <span>Transaksi Penjualan</span>
                </a>
            </li>
            <!-- Stok Management -->
            <li class="menu-header">Manajemen Stok</li>
            <!-- Stok -->
            <li class="{{ Request::is('stock') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('stock')}}">
                    <i class="fas fa-box"></i> <span>Stok Barang</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
