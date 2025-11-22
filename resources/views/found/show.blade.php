@extends('layouts.app')

@section('title', $item->item_name . ' — Found Item Details')

@section('header-actions')
<div class="d-flex gap-2">
  <a href="{{ route('found.index') }}" class="btn btn-outline-light">
    <i class="fas fa-arrow-left me-1"></i>Back to Found Items
  </a>
  <a href="{{ route('found.edit', $item->id) }}" class="btn btn-outline-light">
    <i class="fas fa-edit me-1"></i>Edit
  </a>
</div>
@endsection

@push('styles')
<style>
.item-detail-container {
  padding: 2rem 0;
}

.item-card {
  background: var(--card-bg);
  border-radius: 20px;
  padding: 2rem;
  box-shadow: var(--shadow-lg);
  border: 1px solid var(--border-color);
}

.item-image {
  border-radius: 12px;
  width: 100%;
  height: 400px;
  object-fit: cover;
}

.no-image {
  height: 400px;
  background: var(--light-bg);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-muted);
}

.detail-section {
  margin-bottom: 2rem;
}

.detail-label {
  font-weight: 600;
  color: var(--text-secondary);
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.detail-value {
  color: var(--text-primary);
  font-size: 1.1rem;
  margin-bottom: 1rem;
}

.finder-info-card {
  background: linear-gradient(135deg, #fffbeb, #fef3c7);
  border: 1px solid #fcd34d;
  border-radius: 12px;
  padding: 1.5rem;
  margin: 1.5rem 0;
}

.status-badge {
  font-size: 0.9rem;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  font-weight: 600;
}

.action-buttons {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid var(--border-color);
}

@media (max-width: 768px) {
  .item-detail-container {
    padding: 1rem 0;
  }

  .item-card {
    padding: 1.5rem;
  }

  .action-buttons {
    flex-direction: column;
  }
}
</style>
@endpush

@section('content')
<div class="container-fluid">
  <div class="item-detail-container">
    <div class="item-card">
      <div class="row">
        <!-- Item Image -->
        <div class="col-md-5 mb-4">
          @if($item->photo)
          <img src="{{ asset('storage/' . $item->photo) }}" class="item-image" alt="{{ $item->item_name }}">
          @else
          <div class="no-image">
            <div class="text-center">
              <i class="fas fa-image fa-4x mb-3"></i>
              <p>No Image Available</p>
            </div>
          </div>
          @endif
        </div>

        <!-- Item Details -->
        <div class="col-md-7">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <h1 class="h2 fw-bold">{{ $item->item_name }}</h1>
            <span
              class="status-badge {{ $item->status == 'found' ? 'bg-warning text-dark' : 'bg-success text-white' }}">
              {{ ucfirst($item->status) }}
            </span>
          </div>

          <!-- Finder Information -->
          <div class="finder-info-card">
            <h5 class="fw-bold mb-3"><i class="fas fa-user me-2"></i>Finder Information</h5>
            <div class="row">
              <div class="col-sm-6">
                <div class="detail-label">Finder Name</div>
                <div class="detail-value">{{ $item->finder_name }}</div>
              </div>
              <div class="col-sm-6">
                <div class="detail-label">Contact Information</div>
                <div class="detail-value">{{ $item->finder_contact }}</div>
              </div>
            </div>
          </div>

          <!-- Item Details -->
          <div class="detail-section">
            <div class="row">
              <div class="col-sm-6">
                <div class="detail-label">Category</div>
                <div class="detail-value">
                  <span class="badge bg-light text-dark">{{ $item->category ?? 'Not specified' }}</span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="detail-label">Location Found</div>
                <div class="detail-value">
                  <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                  {{ $item->location_found }}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="detail-label">Date Found</div>
                <div class="detail-value">
                  <i class="far fa-calendar me-2 text-muted"></i>
                  {{ \Carbon\Carbon::parse($item->date_found)->format('F j, Y') }}
                </div>
              </div>
              <div class="col-sm-6">
                <div class="detail-label">Date Reported</div>
                <div class="detail-value">
                  <i class="far fa-clock me-2 text-muted"></i>
                  {{ $item->created_at->format('F j, Y') }}
                </div>
              </div>
            </div>
          </div>

          <!-- Description -->
          @if($item->description)
          <div class="detail-section">
            <div class="detail-label">Description</div>
            <div class="detail-value" style="line-height: 1.6;">
              {{ $item->description }}
            </div>
          </div>
          @endif
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="action-buttons">
        <a href="{{ route('found.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left me-1"></i>Back to List
        </a>
        <a href="{{ route('found.edit', $item->id) }}" class="btn btn-warning">
          <i class="fas fa-edit me-1"></i>Edit Item
        </a>
        <form action="{{ route('found.destroy', $item->id) }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger"
            onclick="return confirm('Are you sure you want to delete this found item?')">
            <i class="fas fa-trash me-1"></i>Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection