<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lost Items — Lost & Found</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
  :root {
    --primary-color: #4361ee;
    --secondary-color: #3a0ca3;
    --accent-color: #4cc9f0;
    --light-color: #f8f9fa;
    --dark-color: #212529;
    --success-color: #4bb543;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
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

  .btn-outline-light:hover {
    color: var(--primary-color);
  }

  .card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: var(--hover-shadow);
  }

  .card-img-top {
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .card:hover .card-img-top {
    transform: scale(1.05);
  }

  .card-body {
    padding: 1.5rem;
  }

  .card-title {
    font-weight: 600;
    color: var(--secondary-color);
  }

  .truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .badge-lost {
    background-color: var(--danger-color);
  }

  .badge-found {
    background-color: var(--warning-color);
    color: var(--dark-color);
  }

  .badge-returned {
    background-color: var(--success-color);
  }

  .search-container {
    position: relative;
  }

  .search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
  }

  .search-input {
    padding-left: 45px;
    border-radius: 50px;
    border: 1px solid #e2e8f0;
  }

  .search-input:focus {
    border-color: var(--accent-color);
    box-shadow: 0 0 0 0.2rem rgba(76, 201, 240, 0.25);
  }

  .filter-container {
    background-color: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: var(--card-shadow);
    margin-bottom: 1.5rem;
  }

  .filter-title {
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--secondary-color);
  }

  .status-filter .btn {
    border-radius: 20px;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
  }

  .no-results {
    text-align: center;
    padding: 3rem 1rem;
  }

  .no-results-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
  }

  .pagination .page-link {
    color: var(--primary-color);
    border-color: #dee2e6;
  }

  .pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
  }

  .item-counter {
    background-color: white;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    box-shadow: var(--card-shadow);
    display: inline-block;
  }

  .modal-content {
    border-radius: 12px;
    overflow: hidden;
  }
  </style>
</head>

<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="fas fa-search me-2"></i>Lost & Found
      </a>
      <div class="d-flex">
        <a href="{{ route('lost.create') }}" class="btn btn-outline-light">
          <i class="fas fa-plus me-1"></i>Report Lost Item
        </a>
      </div>
    </div>
  </nav>

  <main class="container py-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row mb-4 align-items-center">
      <div class="col-md-6">
        <h1 class="h2 mb-2 fw-bold text-primary">Lost Items</h1>
        <div class="item-counter">
          <span class="text-muted">Showing</span>
          <span id="item-count" class="fw-bold text-primary">{{ $items->count() }}</span>
          <span class="text-muted">item(s)</span>
        </div>
      </div>

      <div class="col-md-6">
        <div class="search-container">
          <i class="fas fa-search search-icon"></i>
          <input type="text" id="search-input" class="form-control search-input"
            placeholder="Search items by name, location or category...">
        </div>
      </div>
    </div>

    <div class="filter-container">
      <h5 class="filter-title"><i class="fas fa-filter me-2"></i>Filter by Status</h5>
      <div class="status-filter">
        <button class="btn btn-outline-primary active" data-status="all">All</button>
        <button class="btn btn-outline-danger" data-status="lost">Lost</button>
        <button class="btn btn-outline-warning" data-status="found">Found</button>
        <button class="btn btn-outline-success" data-status="returned">Returned</button>
      </div>
    </div>

    <div id="no-results" class="card shadow-sm d-none">
      <div class="card-body no-results">
        <div class="no-results-icon">
          <i class="fas fa-search"></i>
        </div>
        <h4 class="mb-2">No matching items found</h4>
        <p class="text-muted mb-3">Try adjusting your search or filter criteria.</p>
        <button id="reset-filters" class="btn btn-primary">Reset Filters</button>
      </div>
    </div>

    <div id="items-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      @foreach($items as $item)
      <div class="col item-card" data-name="{{ strtolower($item->item_name) }}"
        data-location="{{ strtolower($item->location_lost) }}" data-category="{{ strtolower($item->category ?? '') }}"
        data-status="{{ $item->status }}">
        <div class="card h-100 shadow-sm">
          @if($item->photo)
          <img src="{{ asset($item->photo) }}" class="card-img-top" alt="{{ $item->item_name }}"
            data-photo="{{ asset($item->photo) }}">
          @else
          <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
            <i class="fas fa-image fa-3x text-muted"></i>
          </div>
          @endif

          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $item->item_name }}</h5>
            <div class="mb-2">
              <span class="badge rounded-pill bg-light text-dark">
                <i class="fas fa-map-marker-alt me-1"></i>{{ $item->location_lost }}
              </span>
            </div>
            <p class="card-text mb-2">
              <small class="text-muted">
                <i class="far fa-calendar me-1"></i>
                {{ \Carbon\Carbon::parse($item->date_lost)->format('M d, Y') }}
              </small>
            </p>
            <p class="text-muted mb-2 truncate">
              {{ Str::limit($item->description ?? 'No description provided', 90) }}
            </p>

            <div class="mt-auto d-flex justify-content-between align-items-center">
              <a href="{{ route('lost.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye me-1"></i>View Details
              </a>
              <span
                class="badge rounded-pill {{ $item->status=='lost' ? 'badge-lost' : ($item->status=='found' ? 'badge-found' : 'badge-returned') }}">
                {{ ucfirst($item->status) }}
              </span>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
      @if(method_exists($items, 'links'))
      {{ $items->withQueryString()->links() }}
      @endif
    </div>
  </main>

  <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header border-0 pb-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0 text-center">
          <img src="#" id="modalImage" class="img-fluid rounded" alt="preview">
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const statusButtons = document.querySelectorAll('.status-filter .btn');
    const itemCards = document.querySelectorAll('.item-card');
    const itemsContainer = document.getElementById('items-container');
    const noResults = document.getElementById('no-results');
    const itemCount = document.getElementById('item-count');
    const resetFiltersBtn = document.getElementById('reset-filters');

    let currentStatusFilter = 'all';
    let currentSearchTerm = '';

    // Filter items based on search and status
    function filterItems() {
      let visibleCount = 0;

      itemCards.forEach(card => {
        const itemName = card.getAttribute('data-name');
        const itemLocation = card.getAttribute('data-location');
        const itemCategory = card.getAttribute('data-category');
        const itemStatus = card.getAttribute('data-status');

        const matchesSearch = currentSearchTerm === '' ||
          itemName.includes(currentSearchTerm) ||
          itemLocation.includes(currentSearchTerm) ||
          itemCategory.includes(currentSearchTerm);

        const matchesStatus = currentStatusFilter === 'all' || itemStatus === currentStatusFilter;

        if (matchesSearch && matchesStatus) {
          card.style.display = 'block';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });

      // Update item count
      itemCount.textContent = visibleCount;

      // Show/hide no results message
      if (visibleCount === 0) {
        noResults.classList.remove('d-none');
        itemsContainer.classList.add('d-none');
      } else {
        noResults.classList.add('d-none');
        itemsContainer.classList.remove('d-none');
      }
    }

    // Search input event listener
    searchInput.addEventListener('input', function() {
      currentSearchTerm = this.value.trim().toLowerCase();
      filterItems();
    });

    // Status filter event listeners
    statusButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Update active button
        statusButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        // Update status filter
        currentStatusFilter = this.getAttribute('data-status');
        filterItems();
      });
    });

    // Reset filters
    resetFiltersBtn.addEventListener('click', function() {
      searchInput.value = '';
      currentSearchTerm = '';

      statusButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-status') === 'all') {
          btn.classList.add('active');
        }
      });

      currentStatusFilter = 'all';
      filterItems();
    });

    // Photo modal functionality
    document.addEventListener('click', function(e) {
      const el = e.target.closest('[data-photo]');
      if (!el) return;
      const src = el.getAttribute('data-photo');
      document.getElementById('modalImage').src = src;
      const modal = new bootstrap.Modal(document.getElementById('photoModal'));
      modal.show();
    });
  });
  </script>
</body>

</html>