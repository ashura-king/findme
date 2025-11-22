@extends('layouts.app')

@section('title', 'Dashboard — Lost & Found')

@section('header-actions')
<div class="d-flex gap-2">
  <a href="{{ route('lost.create') }}" class="btn btn-outline-light">
    <i class="fas fa-binoculars me-1"></i>Report Lost
  </a>
  <a href="{{ route('found.create') }}" class="btn btn-light">
    <i class="fas fa-eye me-1"></i>Report Found
  </a>
</div>
@endsection

@push('styles')
<style>
  :root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --primary-light: #818cf8;
    --secondary-color: #f59e0b;
    --accent-color: #06b6d4;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --info-color: #3b82f6;
    --light-bg: #f8fafc;
    --card-bg: #ffffff;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --text-muted: #94a3b8;
    --border-color: #e2e8f0;
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  }

  body {
    background: linear-gradient(135deg, var(--light-bg) 0%, #f1f5f9 100%);
  }

  .dashboard {
    padding: 0;
  }

  /* Enhanced Stats Cards */
  .stats-card {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: var(--shadow-md);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
  }

  .stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
  }

  .stats-card.lost::before {
    background: linear-gradient(90deg, var(--danger-color), #f87171);
  }

  .stats-card.found::before {
    background: linear-gradient(90deg, var(--warning-color), #fbbf24);
  }

  .stats-card.returned::before {
    background: linear-gradient(90deg, var(--success-color), #34d399);
  }

  .stats-card.users::before {
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
  }

  .stats-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
  }

  .stats-icon {
    font-size: 2.75rem;
    margin-bottom: 1rem;
    opacity: 0.9;
    background: linear-gradient(135deg, currentColor, transparent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .stats-number {
    font-size: 2.75rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    line-height: 1;
    background: linear-gradient(135deg, var(--text-primary), var(--text-secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .stats-label {
    color: var(--text-secondary);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
  }

  .stats-change {
    font-size: 0.875rem;
    font-weight: 600;
    display: flex;
    align-items: center;
  }

  .stats-change.positive {
    color: var(--success-color);
  }

  .stats-change.negative {
    color: var(--danger-color);
  }

  /* Enhanced Quick Actions */
  .quick-actions {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    height: 100%;
    border: 1px solid var(--border-color);
  }

  .action-btn {
    display: flex;
    align-items: center;
    padding: 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    margin-bottom: 1rem;
    background: var(--card-bg);
  }

  .action-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-color: var(--primary-color);
    color: white;
    transform: translateX(8px) scale(1.02);
    box-shadow: var(--shadow-lg);
  }

  .action-btn:hover .action-icon {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
  }

  .action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.25rem;
    font-size: 1.4rem;
    transition: all 0.3s ease;
  }

  /* Enhanced Recent Activity */
  .recent-activity {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
  }

  .activity-item {
    display: flex;
    align-items: flex-start;
    padding: 1.25rem 0;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.3s ease;
  }

  .activity-item:hover {
    background: var(--light-bg);
    margin: 0 -1rem;
    padding: 1.25rem 1rem;
    border-radius: 8px;
  }

  .activity-item:last-child {
    border-bottom: none;
  }

  .activity-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
    font-size: 1.2rem;
    box-shadow: var(--shadow-sm);
  }

  .activity-content {
    flex: 1;
  }

  .activity-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
  }

  .activity-time {
    color: var(--text-muted);
    font-size: 0.875rem;
  }

  .activity-badge {
    margin-left: auto;
    flex-shrink: 0;
    font-size: 0.75rem;
    font-weight: 600;
  }

  /* Enhanced Map Container */
  .map-container {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    height: 100%;
    border: 1px solid var(--border-color);
  }

  .map-placeholder {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    border-radius: 12px;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    position: relative;
    overflow: hidden;
  }

  .map-placeholder::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }

  /* Enhanced Section Titles */
  .section-title {
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--border-color);
    font-size: 1.25rem;
    position: relative;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
  }

  /* Enhanced Recent Items */
  .recent-items {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
  }

  .item-card {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: var(--card-bg);
  }

  .item-card:hover {
    border-color: var(--primary-color);
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
  }

  .item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
  }

  .item-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
    font-size: 1.1rem;
  }

  .item-meta {
    color: var(--text-muted);
    font-size: 0.875rem;
    display: flex;
    gap: 1rem;
  }

  .item-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
    line-height: 1.5;
  }

  /* Enhanced Finder Info */
  .finder-info {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border-radius: 8px;
    padding: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
    border-left: 4px solid var(--accent-color);
  }

  .finder-info i {
    width: 16px;
    margin-right: 0.5rem;
    color: var(--accent-color);
  }

  /* Enhanced Empty States */
  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-muted);
  }

  .empty-state i {
    font-size: 3.5rem;
    margin-bottom: 1rem;
    opacity: 0.5;
    background: linear-gradient(135deg, var(--text-muted), var(--border-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  /* Enhanced Buttons */
  .btn-outline-primary {
    border-color: var(--primary-color);
    color: var(--primary-color);
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-outline-primary:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
  }

  .view-all {
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
    margin-top: 1.5rem;
  }

  /* Welcome Section Enhancement */
  .welcome-badge {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .stats-number {
      font-size: 2.25rem;
    }

    .action-btn {
      padding: 1rem;
    }

    .stats-card,
    .quick-actions,
    .recent-activity,
    .map-container,
    .recent-items {
      padding: 1.5rem;
    }

    .container-fluid {
      padding: 0 1rem;
    }
  }

  /* Custom Scrollbar */
  ::-webkit-scrollbar {
    width: 6px;
  }

  ::-webkit-scrollbar-track {
    background: var(--light-bg);
  }

  ::-webkit-scrollbar-thumb {
    background: var(--primary-light);
    border-radius: 3px;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: var(--primary-color);
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
  <!-- Welcome Section -->
  <div class="row mb-5">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h1 class="h2 mb-2 fw-bold" style="color: var(--text-primary);">Welcome back,
            {{ auth()->user()->name ?? 'User' }}! 👋
          </h1>
          <p class="mb-0" style="color: var(--text-secondary);">Here's what's happening with your lost and found items
            today.</p>
        </div>
        <div class="d-none d-md-block">
          <span class="welcome-badge">
            <i class="fas fa-calendar me-1"></i>
            {{ \Carbon\Carbon::now()->format('F j, Y') }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card lost">
        <div class="stats-icon text-danger">
          <i class="fas fa-binoculars"></i>
        </div>
        <div class="stats-number text-danger">{{ $stats['lost_items'] }}</div>
        <div class="stats-label">Lost Items</div>
        <div class="stats-change {{ $stats['lost_change'] >= 0 ? 'positive' : 'negative' }}">
          <i class="fas fa-arrow-{{ $stats['lost_change'] >= 0 ? 'up' : 'down' }} me-1"></i>
          {{ abs($stats['lost_change']) }}% from last week
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card found">
        <div class="stats-icon text-warning">
          <i class="fas fa-eye"></i>
        </div>
        <div class="stats-number text-warning">{{ $stats['found_items'] }}</div>
        <div class="stats-label">Found Items</div>
        <div class="stats-change {{ $stats['found_change'] >= 0 ? 'positive' : 'negative' }}">
          <i class="fas fa-arrow-{{ $stats['found_change'] >= 0 ? 'up' : 'down' }} me-1"></i>
          {{ abs($stats['found_change']) }}% from last week
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card returned">
        <div class="stats-icon text-success">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stats-number text-success">{{ $stats['returned_items'] }}</div>
        <div class="stats-label">Returned Items</div>
        <div class="stats-change {{ $stats['returned_change'] >= 0 ? 'positive' : 'negative' }}">
          <i class="fas fa-arrow-{{ $stats['returned_change'] >= 0 ? 'up' : 'down' }} me-1"></i>
          {{ abs($stats['returned_change']) }}% from last week
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card users">
        <div class="stats-icon text-primary">
          <i class="fas fa-users"></i>
        </div>
        <div class="stats-number text-primary">{{ $stats['active_users'] }}</div>
        <div class="stats-label">Active Users</div>
        <div class="stats-change {{ $stats['users_change'] >= 0 ? 'positive' : 'negative' }}">
          <i class="fas fa-arrow-{{ $stats['users_change'] >= 0 ? 'up' : 'down' }} me-1"></i>
          {{ abs($stats['users_change']) }}% from last week
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Found Items Section -->
  <div class="row mb-5">
    <div class="col-12">
      <div class="recent-items">
        <h3 class="section-title">Recently Found Items</h3>

        @if($recentFoundItems->count() > 0)
        @foreach($recentFoundItems as $item)
        <div class="item-card">
          <!-- Image Display -->
          @if($item->photo)
          <div style="margin-bottom: 1rem; text-align: center;">
            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->item_name }}"
              style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid var(--border-color);">
          </div>
          @endif

          <div class="item-header">
            <div>
              <div class="item-name">{{ $item->item_name }}</div>
              <div class="item-meta">
                <span><i class="fas fa-map-marker-alt"></i> {{ $item->location_found }}</span>
                <span><i class="fas fa-calendar"></i> {{ $item->date_found->format('M d, Y') }}</span>
              </div>
            </div>
            <span class="badge rounded-pill {{ $item->status == 'unclaimed' ? 'bg-warning' : 'bg-success' }}">
              {{ ucfirst($item->status) }}
            </span>
          </div>

          @if($item->description)
          <div class="item-description">
            {{ Str::limit($item->description, 120) }}
          </div>
          @endif

          <div class="finder-info">
            <div><i class="fas fa-user"></i>Found by: {{ $item->finder_name }}</div>
            @if($item->finder_contact)
            <div><i class="fas fa-phone"></i>Contact: {{ $item->finder_contact }}</div>
            @endif
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
              Reported {{ $item->created_at->diffForHumans() }}
            </small>
            <a href="{{ route('found.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
              View Details
            </a>
          </div>
        </div>
        @endforeach

        <div class="view-all">
          <a href="{{ route('found.index') }}" class="btn btn-outline-primary">
            View All Found Items <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
        @else
        <div class="empty-state">
          <i class="fas fa-box-open"></i>
          <h4>No Found Items Yet</h4>
          <p class="mb-3">Be the first to report a found item!</p>
          <a href="{{ route('found.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Report First Found Item
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Enhanced animation with smoother easing
    const animateValue = (element, start, end, duration) => {
      let startTimestamp = null;
      const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        // Easing function for smoother animation
        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
        const value = Math.floor(easeOutQuart * (end - start) + start);
        element.textContent = value.toLocaleString();
        if (progress < 1) {
          window.requestAnimationFrame(step);
        }
      };
      window.requestAnimationFrame(step);
    };


    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const element = entry.target;
          const finalValue = parseInt(element.textContent);
          animateValue(element, 0, finalValue, 1800);
          observer.unobserve(element);
        }
      });
    }, {
      threshold: 0.5,
      rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.stats-number').forEach(element => {
      observer.observe(element);
    });

    // Add hover effects to cards
    const cards = document.querySelectorAll('.stats-card, .item-card, .action-btn');
    cards.forEach(card => {
      card.addEventListener('mouseenter', function() {
        this.style.transform = this.classList.contains('stats-card') ?
          'translateY(-8px) scale(1.02)' :
          'translateY(-2px)';
      });

      card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
      });
    });
  });
</script>
@endpush