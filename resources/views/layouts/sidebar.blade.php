<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-leaf text-success me-2"></i>
        Citizen Connect
    </div>
    
    <ul class="nav-links">
        
        <!-- ================= CITIZEN ================= -->
        @if(Auth::user()->role == 'citizen')
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('complaints.index') }}" class="{{ request()->routeIs('complaints.index') ? 'active' : '' }}">
                    <i class="fas fa-list-alt"></i> View Complaints
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('complaints.create') }}" class="{{ request()->routeIs('complaints.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> New Complaint
                </a>
            </li>
        @endif

        <!-- ================= ADMIN ================= -->
        @if(Auth::user()->role == 'admin')
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.departments') }}" class="{{ request()->routeIs('admin.departments') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Departments
                </a>
            </li>
             <!-- Added All Complaints View for Admin -->
             <li class="nav-item">
                <a href="{{ route('admin.complaints') }}" class="{{ request()->routeIs('admin.complaints') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> All Complaints
                </a>
            </li>
        @endif

        <!-- ================= DEPARTMENT ================= -->
        @if(Auth::user()->role == 'department')
            <li class="nav-item">
                <a href="{{ route('department.dashboard') }}" class="{{ request()->routeIs('department.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dept.complaints') }}" class="{{ request()->routeIs('dept.complaints') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i> Assigned Complaints
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dept.categories') }}" class="{{ request()->routeIs('dept.categories') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> Categories
                </a>
            </li>
        @endif

        <!-- ================= COMMON ================= -->
        <li class="nav-item">
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> Edit Profile
            </a>
        </li>
        
        <li style="margin-top: auto;"></li> 
        
        <!-- Logout -->
        <li class="nav-item border-top border-secondary mt-4 pt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt text-warning"></i> Logout
                </a>
            </form>
        </li>
    </ul>
</aside>
