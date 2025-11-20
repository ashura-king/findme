@extends('layouts.app')

@section('title','Lost Items — FindMyStuff')

@section('header-actions')
<a href="{{ route('lost.create') }}" class="btn btn-outline-light">
  <i class="fas fa-plus me-1"></i>Report Lost Item
</a>
@endsection

@section('content')
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

<!-- Items grid -->
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
@endsection

@push('styles')
<style>
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

.status-filter .btn {
  border-radius: 20px;
  margin-right: 0.5rem;
  margin-bottom: 0.5rem;
}

.item-counter {
  background-color: white;
  border-radius: 10px;
  padding: 0.75rem 1rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  display: inline-block;
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
  background-color: #4bb543;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('search-input');
  const statusButtons = document.querySelectorAll('.status-filter .btn');
  const itemCards = document.querySelectorAll('.item-card');
  const itemsContainer = document.getElementById('items-container');
  const itemCount = document.getElementById('item-count');
  let currentStatusFilter = 'all';
  let currentSearchTerm = '';

  function filterItems() {
    let visibleCount = 0;
    itemCards.forEach(card => {
      const itemName = card.dataset.name;
      const itemLocation = card.dataset.location;
      const itemCategory = card.dataset.category;
      const itemStatus = card.dataset.status;

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

    itemCount.textContent = visibleCount;
  }

  searchInput.addEventListener('input', function() {
    currentSearchTerm = this.value.trim().toLowerCase();
    filterItems();
  });

  statusButtons.forEach(button => {
    button.addEventListener('click', function() {
      statusButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      currentStatusFilter = this.dataset.status;
      filterItems();
    });
  });
});
</script>
@endpush