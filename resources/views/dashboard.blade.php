@extends('app')

@section('title', 'Dashboard — Lost & Found')

@section('header-actions')
<div class="d-flex gap-2">
  <a href="{{ route('lost.create') }}" class="btn btn-outline-primary">
    <i class="fas fa-plus me-1"></i>Report Lost
  </a>
  <a href="{{ route('found.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i>Report Found
  </a>
</div>
@endsection

@section('content')
<style>
  .dashboard {
    padding: 0;
  }

  .stats-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
    border-left: 4px solid;
  }

  .stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
  }

  .stats-card.lost {
    border-left-color: #dc3545;
  }

  .stats-card.found {
    border-left-color: #ffc107;
  }

  .stats-card.returned {
    border-left-color: #198754;
  }

  .stats-card.users {
    border-left-color: #4361ee;
  }

  .stats-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    opacity: 0.8;
  }

  .stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    line-height: 1;
  }

  .stats-label {
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 0.5rem;
  }

  .stats-change {
    font-size: 0.875rem;
    font-weight: 500;
  }

  .stats-change.positive {
    color: #198754;
  }

  .stats-change.negative {
    color: #dc3545;
  }

  .quick-actions {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    height: 100%;
  }

  .action-btn {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    text-decoration: none;
    color: #495057;
    transition: all 0.3s ease;
    margin-bottom: 0.75rem;
  }

  .action-btn:hover {
    background-color: #f8f9fa;
    border-color: #4361ee;
    color: #4361ee;
    transform: translateX(5px);
  }

  .action-btn:last-child {
    margin-bottom: 0;
  }

  .action-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.2rem;
  }

  .recent-activity {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .activity-item {
    display: flex;
    align-items: flex-start;
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
  }

  .activity-item:last-child {
    border-bottom: none;
  }

  .activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
  }

  .activity-content {
    flex: 1;
  }

  .activity-title {
    font-weight: 500;
    margin-bottom: 0.25rem;
  }

  .activity-time {
    color: #6c757d;
    font-size: 0.875rem;
  }

  .activity-badge {
    margin-left: auto;
    flex-shrink: 0;
  }

  .map-container {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    height: 100%;
  }

  .map-placeholder {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 500;
  }

  .section-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f1f3f4;
  }

  .recent-items {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .item-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
  }

  .item-card:hover {
    border-color: #4361ee;
    box-shadow: 0 2px 8px rgba(67, 97, 238, 0.15);
  }

  .item-card:last-child {
    margin-bottom: 0;
  }

  .item-header {
    display: flex;
    justify-content: between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
  }

  .item-name {
    font-weight: 500;
    margin-bottom: 0.25rem;
  }

  .item-meta {
    color: #6c757d;
    font-size: 0.875rem;
    display: flex;
    gap: 1rem;
  }

  .item-description {
    color: #495057;
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
  }

  .view-all {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
    margin-top: 1rem;
  }

  .empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
  }

  .empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
  }

  @media (max-width: 768px) {
    .stats-number {
      font-size: 2rem;
    }

    .action-btn {
      padding: 0.75rem;
    }
  }
</style>

<div class="dashboard">
  <!-- Welcome Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h1 class="h2 mb-2 fw-bold text-primary">Welcome back, {{ auth()->user()->name ?? 'User' }}! 👋</h1>
          <p class="text-muted mb-0">Here's what's happening with your lost and found items today.</p>
        </div>
        <div class="d-none d-md-block">
          <span class="badge bg-light text-dark">
            <i class="fas fa-calendar me-1"></i>
            {{ \Carbon\Carbon::now()->format('F j, Y') }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card lost">
        <div class="stats-icon text-danger">
          <i class="fas fa-binoculars"></i>
        </div>
        <div class="stats-number text-danger">24</div>
        <div class="stats-label">Lost Items</div>
        <div class="stats-change positive">
          <i class="fas fa-arrow-up me-1"></i>12% from last week
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card found">
        <div class="stats-icon text-warning">
          <i class="fas fa-eye"></i>
        </div>
        <div class="stats-number text-warning">18</div>
        <div class="stats-label">Found Items</div>
        <div class="stats-change positive">
          <i class="fas fa-arrow-up me-1"></i>8% from last week
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card returned">
        <div class="stats-icon text-success">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stats-number text-success">12</div>
        <div class="stats-label">Returned Items</div>
        <div class="stats-change positive">
          <i class="fas fa-arrow-up me-1"></i>15% from last week
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card users">
        <div class="stats-icon text-primary">
          <i class="fas fa-users"></i>
        </div>
        <div class="stats-number text-primary">156</div>
        <div class="stats-label">Active Users</div>
        <div class="stats-change positive">
          <i class="fas fa-arrow-up me-1"></i>5% from last week
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Left Column -->
    <div class="col-lg-8">
      <!-- Quick Actions -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="quick-actions">
            <h3 class="section-title">Quick Actions</h3>
            <div class="row">
              <div class="col-md-6">
                <a href="{{ route('lost.create') }}" class="action-btn">
                  <div class="action-icon bg-danger text-white">
                    <i class="fas fa-binoculars"></i>
                  </div>
                  <div>
                    <div class="fw-bold">Report Lost Item</div>
                    <small class="text-muted">Can't find something? Report it here</small>
                  </div>
                </a>
                <a href="{{ route('found.create') }}" class="action-btn">
                  <div class="action-icon bg-warning text-dark">
                    <i class="fas fa-eye"></i>
                  </div>
                  <div>
                    <div class="fw-bold">Report Found Item</div>
                    <small class="text-muted">Found something? Help return it</small>
                  </div>
                </a>
              </div>
              <div class="col-md-6">
                <a href="{{ route('map') }}" class="action-btn">
                  <div class="action-icon bg-info text-white">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <div>
                    <div class="fw-bold">View Map</div>
                    <small class="text-muted">See items on interactive map</small>
                  </div>
                </a>
                <a href="{{ route('notifications') }}" class="action-btn">
                  <div class="action-icon bg-primary text-white">
                    <i class="fas fa-bell"></i>
                  </div>
                  <div>
                    <div class="fw-bold">Notifications</div>
                    <small class="text-muted">Check your alerts and matches</small>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Items & Activity -->
      <div class="row">
        <!-- Recent Lost Items -->
        <div class="col-md-6 mb-4">
          <div class="recent-items">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h3 class="section-title mb-0">Recent Lost Items</h3>
              <a href="{{ route('lost.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>

            @if($recentLostItems && $recentLostItems->count() > 0)
            @foreach($recentLostItems->take(3) as $item)
            <div class="item-card">
              <div class="item-header">
                <div class="flex-grow-1">
                  <div class="item-name">{{ $item->item_name }}</div>
                  <div class="item-meta">
                    <span><i class="fas fa-map-marker-alt me-1"></i>{{ $item->location_lost }}</span>
                    <span><i
                        class="far fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($item->date_lost)->format('M d') }}</span>
                  </div>
                </div>
                <span class="badge bg-danger">Lost</span>
              </div>
              @if($item->description)
              <div class="item-description">
                {{ Str::limit($item->description, 80) }}
              </div>
              @endif
              <a href="{{ route('lost.show', $item->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
            </div>
            @endforeach
            @else
            <div class="empty-state">
              <i class="fas fa-binoculars"></i>
              <p>No recent lost items</p>
              <a href="{{ route('lost.create') }}" class="btn btn-primary">Report First Item</a>
            </div>
            @endif
          </div>
        </div>

        <!-- Recent Found Items -->
        <div class="col-md-6 mb-4">
          <div class="recent-items">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h3 class="section-title mb-0">Recent Found Items</h3>
              <a href="{{ route('found.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>

            @if($recentFoundItems && $recentFoundItems->count() > 0)
            @foreach($recentFoundItems->take(3) as $item)
            <div class="item-card">
              <div class="item-header">
                <div class="flex-grow-1">
                  <div class="item-name">{{ $item->item_name }}</div>
                  <div class="item-meta">
                    <span><i class="fas fa-map-marker-alt me-1"></i>{{ $item->location_found }}</span>
                    <span><i
                        class="far fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($item->date_found)->format('M d') }}</span>
                  </div>
                </div>
                <span class="badge bg-warning text-dark">Found</span>
              </div>
              @if($item->description)
              <div class="item-description">
                {{ Str::limit($item->description, 80) }}
              </div>
              @endif
              <a href="{{ route('found.show', $item->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
            </div>
            @endforeach
            @else
            <div class="empty-state">
              <i class="fas fa-eye"></i>
              <p>No recent found items</p>
              <a href="{{ route('found.create') }}" class="btn btn-primary">Report First Item</a>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
      <!-- Recent Activity -->
      <div class="recent-activity mb-4">
        <h3 class="section-title">Recent Activity</h3>

        <div class="activity-item">
          <div class="activity-icon bg-success text-white">
            <i class="fas fa-check"></i>
          </div>
          <div class="activity-content">
            <div class="activity-title">iPhone returned to owner</div>
            <div class="activity-time">2 hours ago</div>
          </div>
          <span class="activity-badge badge bg-success">Returned</span>
        </div>

        <div class="activity-item">
          <div class="activity-icon bg-warning text-dark">
            <i class="fas fa-eye"></i>
          </div>
          <div class="activity-content">
            <div class="activity-title">Wallet found at Central Park</div>
            <div class="activity-time">5 hours ago</div>
          </div>
          <span class="activity-badge badge bg-warning">Found</span>
        </div>

        <div class="activity-item">
          <div class="activity-icon bg-danger text-white">
            <i class="fas fa-binoculars"></i>
          </div>
          <div class="activity-content">
            <div class="activity-title">Laptop reported missing</div>
            <div class="activity-time">Yesterday, 3:45 PM</div>
          </div>
          <span class="activity-badge badge bg-danger">Lost</span>
        </div>

        <div class="activity-item">
          <div class="activity-icon bg-primary text-white">
            <i class="fas fa-user-plus"></i>
          </div>
          <div class="activity-content">
            <div class="activity-title">New user registered</div>
            <div class="activity-time">Yesterday, 1:20 PM</div>
          </div>
        </div>

        <div class="view-all">
          <a href="{{ route('notifications') }}" class="btn btn-sm btn-outline-primary">View All Activity</a>
        </div>
      </div>

      <!-- Quick Map -->
      <div class="map-container">
        <h3 class="section-title">Recent Locations</h3>
        <div class="map-placeholder">
          <div class="text-center">
            <i class="fas fa-map-marked-alt fa-2x mb-2"></i>
            <div>Interactive Map</div>
            <small class="opacity-75">Showing recent item locations</small>
          </div>
        </div>
        <div class="mt-3">
          <div class="d-flex justify-content-between text-sm mb-2">
            <span><i class="fas fa-circle text-danger me-1"></i> Lost Items</span>
            <span><i class="fas fa-circle text-warning me-1"></i> Found Items</span>
          </div>
          <a href="{{ route('map') }}" class="btn btn-outline-primary w-100">
            <i class="fas fa-expand me-1"></i> Open Full Map
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Dashboard specific JavaScript can go here

    // Example: Animate stats counters
    const animateValue = (element, start, end, duration) => {
      let startTimestamp = null;
      const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = Math.floor(progress * (end - start) + start);
        element.textContent = value.toLocaleString();
        if (progress < 1) {
          window.requestAnimationFrame(step);
        }
      };
      window.requestAnimationFrame(step);
    };

    // Animate stats cards on scroll into view
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const element = entry.target;
          const finalValue = parseInt(element.textContent);
          animateValue(element, 0, finalValue, 2000);
          observer.unobserve(element);
        }
      });
    });

    document.querySelectorAll('.stats-number').forEach(element => {
      observer.observe(element);
    });
  });
</script>
@endpush