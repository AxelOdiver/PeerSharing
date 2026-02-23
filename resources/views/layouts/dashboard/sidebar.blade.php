<aside id="appSidebar" class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <i class="bi bi-grid-1x2-fill brand-image opacity-75"></i>
      <span class="brand-text fw-light">PeerSharing</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <div class="sidebar-user border-bottom border-secondary-subtle">
      <div class="d-flex align-items-center gap-2 p-3">
        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center dashboard-avatar">
          <i class="bi bi-person-fill text-white"></i>
        </div>
        <div class="sidebar-user-meta">
          <div class="fw-semibold text-white">{{ auth()->user()->name ?? 'User' }}</div>
          <small class="text-white-50 d-block">{{ auth()->user()->email ?? '' }}</small>
          <a href="{{ route('profile.edit') }}" class="small link-light">Edit profile</a>
        </div>
      </div>
    </div>

    <nav class="mt-3">
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="navigation"
        aria-label="Main navigation"
        data-accordion="false"
      >
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-person-gear"></i>
            <p>Profile</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
