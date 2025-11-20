<!-- resources/views/components/sidebar.blade.php -->
<style>
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: var(--sidebar-width, 280px);
  background: linear-gradient(180deg, var(--primary-color, #4361ee), var(--secondary-color, #3a0ca3));
  color: white;
  transition: all 0.3s ease;
  z-index: 1000;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar.collapsed {
  width: var(--sidebar-collapsed, 80px);
}

.sidebar-header {
  padding: 1.5rem 1rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.sidebar-brand {
  font-weight: 700;
  font-size: 1.5rem;
  white-space: nowrap;
  overflow: hidden;
}

.sidebar.collapsed .sidebar-brand {
  display: none;
}

.sidebar-toggle-btn {
  background: transparent;
  border: none;
  color: white;
  font-size: 1.2rem;
  cursor: pointer;
}

.sidebar-menu {
  padding: 1rem 0;
  list-style: none;
  margin: 0;
}

.sidebar-menu li {
  margin-bottom: 0.5rem;
}

.sidebar-menu a {
  display: flex;
  align-items: center;
  padding: 0.75rem 1.5rem;
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  transition: all 0.3s ease;
  white-space: nowrap;
  overflow: hidden;
}

.sidebar-menu a:hover,
.sidebar-menu a.active {
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
  border-left: 4px solid var(--accent-color, #4cc9f0);
}

.sidebar-menu i {
  width: 24px;
  margin-right: 1rem;
  font-size: 1.1rem;
  text-align: center;
}

.sidebar.collapsed .sidebar-menu span {
  display: none;
}

.sidebar.collapsed .sidebar-menu i {
  margin-right: 0;
}

.sidebar-footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  padding: 1rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-user-info {
  display: flex;
  align-items: center;
  white-space: nowrap;
  overflow: hidden;
}

.sidebar.collapsed .sidebar-user-info span {
  display: none;
}

.sidebar-user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 0.75rem;
}

.sidebar.collapsed .sidebar-user-avatar {
  margin-right: 0;
}

.sidebar-badge {
  margin-left: auto;
}

.sidebar.collapsed .sidebar-badge {
  display: none;
}

/* Mobile Responsiveness */
@media (max-width: 992px) {
  .sidebar {
    width: var(--sidebar-collapsed, 80px);
  }

  .sidebar.collapsed {
    width: 0;
  }

  .sidebar-brand,
  .sidebar-menu span,
  .sidebar-user-info span {
    display: none;
  }

  .sidebar-menu i {
    margin-right: 0;
  }
}
</style>

<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-brand">
      <i class="fas fa-search me-2"></i>Lost & Found
    </div>
    <button class="sidebar-toggle-btn" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>
  </div>

  <ul class="sidebar-menu">
    <li>
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{ route('lost.index') }}" class="{{ request()->routeIs('lost.index') ? 'active' : '' }}">
        <i class="fas fa-binoculars"></i>
        <span>Lost Items</span>
      </a>
    </li>
    <li>
      <a href="{{ route('found.index') }}" class="{{ request()->routeIs('found.index') ? 'active' : '' }}">
        <i class="fas fa-eye"></i>
        <span>Found Items</span>
      </a>
    </li>
    <li>
      <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
        <i class="fas fa-flag"></i>
        <span>My Reports</span>
      </a>
    </li>
    <li>
      <a href="{{ route('lost.create') }}" class="{{ request()->routeIs('lost.create') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i>
        <span>Report Item</span>
      </a>
    </li>
    <li>
      <a href="{{ route('map') }}" class="{{ request()->routeIs('map') ? 'active' : '' }}">
        <i class="fas fa-map-marker-alt"></i>
        <span>Location Map</span>
      </a>
    </li>
    <li>
      <a href="{{ route('notifications') }}" class="{{ request()->routeIs('notifications') ? 'active' : '' }}">
        <i class="fas fa-bell"></i>
        <span>Notifications</span>
        @if($notificationCount ?? 0 > 0)
        <span class="sidebar-badge badge bg-danger">{{ $notificationCount }}</span>
        @endif
      </a>
    </li>
    <li>
      <a href="{{ route('settings') }}" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
    </li>
  </ul>

  <div class="sidebar-footer">
    <div class="sidebar-user-info">
      <div class="sidebar-user-avatar">
        <i class="fas fa-user"></i>
      </div>
      <div>
        <div class="fw-bold">{{ auth()->user()->name ?? 'User' }}</div>
        <small>{{ auth()->user()->email ?? 'user@example.com' }}</small>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const mainContent = document.getElementById('mainContent');

  // Toggle sidebar collapse
  function toggleSidebar() {
    sidebar.classList.toggle('collapsed');
    if (mainContent) {
      mainContent.classList.toggle('expanded');
    }

    // Save state to localStorage
    const isCollapsed = sidebar.classList.contains('collapsed');
    localStorage.setItem('sidebarCollapsed', isCollapsed);
  }

  sidebarToggle.addEventListener('click', toggleSidebar);

  // Load saved sidebar state
  const savedState = localStorage.getItem('sidebarCollapsed');
  if (savedState === 'true') {
    sidebar.classList.add('collapsed');
    if (mainContent) {
      mainContent.classList.add('expanded');
    }
  }

  // Mobile menu functionality
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', toggleSidebar);
  }
});
</script>