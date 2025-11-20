<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'FindMyStuff')</title>

  <!-- Bootstrap + icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

  <style>
  /* simple layout adjustments */
  body {
    background: #f8f9fa;
  }

  .sidebar-collapsed {
    width: 72px !important;
  }

  #appSidebar {
    transition: width .25s ease;
  }

  .content-area {
    transition: margin-left .25s ease;
  }

  @media (max-width: 768px) {
    #appSidebar {
      position: fixed;
      z-index: 1050;
      left: -320px;
    }

    #appSidebar.show {
      left: 0;
    }
  }
  </style>

  @stack('styles')
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <div class="d-flex align-items-center">
        <!-- sidebar toggle -->
        <button id="sidebarToggle" class="btn btn-light me-2">
          <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand mb-0" href="{{ url('/') }}">FindMyStuff</a>
      </div>

      <div class="d-flex ms-auto">
        <button class="btn btn-outline-primary me-2"><i class="bi bi-bell"></i></button>
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i> User
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="d-flex">
    @include('components.sidebar')

    <main id="mainContent" class="flex-grow-1 p-4 content-area">
      @yield('content')
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // Sidebar toggle (desktop + mobile friendly)
  (function() {
    const btn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('appSidebar');

    btn.addEventListener('click', function() {
      // desktop: toggle narrow class
      if (window.innerWidth > 768) {
        sidebar.classList.toggle('sidebar-collapsed');
      } else {
        // mobile: show/hide slide
        sidebar.classList.toggle('show');
      }
    });
  })();
  </script>

  @stack('scripts')
</body>

</html>