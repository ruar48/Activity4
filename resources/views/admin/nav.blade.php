<style>
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }

    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 5px;
    }

    .badge i {
        margin-right: 5px;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    /* Styles for the navbar */
    .navbar {
        padding: 0.5rem 1rem;
    }

    .navbar-toggler {
        background-color: white;
        border: none;
    }

    .navbar-collapse {
        transition: transform 0.3s ease-in-out;
    }

    .navbar-collapse.collapsing {
        transform: scaleY(0);
    }

    .navbar-collapse.show {
        transform: scaleY(1);
    }

    @media (max-width: 992px) {
        .nav {
            flex-direction: column;
            text-align: center;
        }

        .navbar-collapse {
            transform-origin: top;
            display: none;
        }
        
        .navbar-collapse.show {
            display: block;
        }
    }
</style>

<div class="navbar navbar-expand-lg bg-primary text-white shadow-sm">
    <h4 class="mb-0 text-white"><i class="fas fa-tachometer-alt"></i> Dashboard</h4>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <nav class="nav ms-auto">
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
</div>
