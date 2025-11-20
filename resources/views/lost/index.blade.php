@extends('layouts.app')

@section('title', 'Lost Items - FindMyStuff')

@push('styles')
<style>
.item-counter {
  background-color: #fff;
  border-radius: 10px;
  padding: 0.75rem 1rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  display: inline-block;
  margin-bottom: 1rem;
}

.card {
  border: none;
  border-radius: 12px;
  transition: all 0.3s ease;
  overflow: hidden;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.card-img-top {
  height: 200px;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.card:hover .card-img-top {
  transform: scale(1.05);
}

.truncate {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.badge-lost {
  background-color: #dc3545;
}

.badge-found {
  background-color: #ffc107;
  color: #212529;
}

.badge-returned {
  background-color: #198754;
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
  border-color: #4cc9f0;
  box-shadow: 0 0 0 0.2rem rgba(76, 201, 240, 0.25);
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
</style>
@endpush

@section('content')
<div class="container py-4">
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
        Showing <span id="item-count" class="fw-bold text-primary">{{ $items->count() }}</span> item(s)
      </div>
    </div>

    <div class="col-md-6">
      <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="search-input" class="form-control search-input"
          placeholder="Search items by name, location, or category...">
      </div>
    </div>
  </div>

  <div id="no-results" class="card shadow-sm d-none">
    <div class="card-body no-results">
      <div class="no-results-icon">
        <i class="fas fa-search"></i>
      </div>
      <h4 class="mb-2">No matching items found</h4>
      <p class="text-muted mb-3">Try adjusting your search criteria.</p>
      <button id="reset-search" class="btn btn-primary">Clear Search</button>
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
              class="badge rounded-pill 
                            {{ $item->status == 'lost' ? 'badge-lost' : ($item->status == 'found' ? 'badge-found' : 'badge-returned') }}">
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
    {{ $items->links() }}
    @endif
  </div>
</div>

<!-- Modal for image preview -->
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('search-input');
  const itemCards = document.querySelectorAll('.item-card');
  const itemsContainer = document.getElementById('items-container');
  const noResults = document.getElementById('no-results');
  const itemCount = document.getElementById('item-count');
  const resetSearch = document.getElementById('reset-search');

  function filterItems() {
    let visibleCount = 0;
    const term = searchInput.value.trim().toLowerCase();

    itemCards.forEach(card => {
      const name = card.getAttribute('data-name');
      const location = card.getAttribute('data-location');
      const category = card.getAttribute('data-category');

      const matches = term === '' ||
        name.includes(term) ||
        location.includes(term) ||
        category.includes(term);

      if (matches) {
        card.style.display = 'block';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    // Update item count
    itemCount.textContent = visibleCount;

    // Show/hide no results message
    if (visibleCount === 0 && term !== '') {
      noResults.classList.remove('d-none');
      itemsContainer.classList.add('d-none');
    } else {
      noResults.classList.add('d-none');
      itemsContainer.classList.remove('d-none');
    }
  }

  searchInput.addEventListener('input', filterItems);

  // Reset search
  resetSearch.addEventListener('click', function() {
    searchInput.value = '';
    filterItems();
  });

  // Image modal
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
@endpush