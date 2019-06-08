<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link {{ $page === 'dashboard' ? 'active' : ''}}" href="{{ route('cabinet.dashboard.index') }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $page === 'profile' ? 'active' : ''}}"
           href="{{ route('cabinet.profile.index') }}">Profile</a>
    </li>
</ul>