<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'FindMyStuff')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
  :root {
    --primary-color: #4361ee;
    --secondary-color: #3a0ca3;
    --accent-color: #4cc9f0;
    --light-color: #f8f9fa;
    --dark-color: #212529;
    --success-color: #198754;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
  }

  body {
    background-color: #f5f7fb;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--dark-color);
  }

  .navbar {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
  }

  .btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
  }

  .btn-primary:hover {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
  }
  </style>
  @stack('styles')
</head>

<body class="bg-light">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <i class="fas fa-search me-2"></i>FindMyStuff
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('lost.index') }}">Lost Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('found.index') }}">Found Items</a>
          </li>
        </ul>
        <div class="d-flex">
          <a href="{{ route('lost.create') }}" class="btn btn-outline-light">
            <i class="fas fa-plus me-1"></i>Report Item
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main>
    @yield('content')
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>

</html>