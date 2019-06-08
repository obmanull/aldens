<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link {{ $page === 'dashboard' ? 'active' : ''}}" href="{{ route('admin.dashboard.index') }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $page === 'categories' ? 'active' : ''}}" href="{{ route('admin.categories.index') }}">Categories</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $page === 'users' ? 'active' : ''}}" href="{{ route('admin.users.index') }}">Users</a>
    </li>
</ul>