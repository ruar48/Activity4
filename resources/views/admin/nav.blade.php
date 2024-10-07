<style>
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }

    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.4); /* Change this color to highlight active link */
        border-radius: 5px;
    }

    .badge i {
        margin-right: 5px;
    }

    .table th, .table td {
        vertical-align: middle;
    }
</style>
<div class="d-flex justify-content-between p-3 bg-primary text-white shadow-sm">
    <h4 class="mb-0"><i class="fas fa-tachometer-alt"></i> Dashboard</h4>
    <nav class="nav">
        <a class="nav-link text-white {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <a class="nav-link text-white {{ Request::routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}"><i class="fas fa-users"></i> Users</a>
        <a class="nav-link text-white {{ Request::routeIs('category') ? 'active' : '' }}" href="{{ route('category') }}"><i class="fas fa-list"></i> Category</a>
        <a class="nav-link text-white {{ Request::routeIs('admin.products') ? 'active' : '' }}" href="{{ route('admin.products') }}"><i class="fas fa-box-open"></i> Products</a>
        <a class="nav-link text-white {{ Request::routeIs('charts') ? 'active' : '' }}" href="{{ route('charts') }}"><i class="fas fa-chart-line"></i> Reports</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </nav>
</div>
