<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a class="navbar-brand mx-4 mb-3" href="{{route('dashboard')}}" >
            <h3 class="text-primary"><i class="fa fa-user-shield me-2"></i>HOTD Admin</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <x-rounded-user-image />
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard') }}" class="nav-item nav-link  {{ request()->route()->prefix('/admin')=='/admin' ? "active" : " " }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('adminposts') ? 'active' : ' ' }} " data-bs-toggle="dropdown" aria-expanded="{{ request()->routeIs('adminposts') ? 'true' : 'false' }}"><i class="fa fa-clipboard me-2"></i>Ahadith</a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('adminposts') ? 'show' : '' }}">
                    <a href="{{ route('adminposts') }}" class="dropdown-item {{ request()->routeIs('adminposts') ? 'active' : '' }}">Ahadith</a>
                    <a href="{{ route('admintags') }}" class="dropdown-item {{ request()->routeIs('admintags') ? 'active' : '' }}">Tags</a>
                    <a href="{{ route('adminposted') }}" class="dropdown-item {{ request()->routeIs('adminposted') ? 'active' : '' }}">Posted Ahadith</a>
                    <a href="{{ route('adminscheduled') }}" class="dropdown-item {{ request()->routeIs('adminscheduled') ? 'active' : '' }}">Scheduled</a>
                    <a href="{{ route('admincustomscheduled') }}" class="dropdown-item {{ request()->routeIs('admincustomscheduled') ? 'active' : '' }}">Custom Scheduled</a>
                    <a href="{{ route('adminrecomended') }}" class="dropdown-item {{ request()->routeIs('adminrecomended') ? 'active' : '' }}">Create Schedule</a>
                </div>
                  <?php
                echo date('m/d/Y h:i:s a', time());
            ?>
            </div>
        </div>
    </nav>
</div>