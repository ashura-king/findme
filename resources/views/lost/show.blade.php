<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $item->item_name }} — Lost Item Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
  :root {
    --primary-color: #4a6baf;
    --secondary-color: #6c757d;
    --success-color: #198754;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --light-bg: #f8f9fa;
    --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    --hover-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
  }

  body {
    background-color: var(--light-bg);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
  }

  .container {
    max-width: 1200px;
  }

  .back-btn {
    transition: all 0.3s ease;
    border-radius: 8px;
    padding: 8px 16px;
  }

  .back-btn:hover {
    transform: translateX(-4px);
    background-color: #5a6268;
  }

  .card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: var(--card-shadow);
  }

  .card:hover {
    box-shadow: var(--hover-shadow);
  }

  .item-image {
    border-radius: 12px;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .item-image:hover {
    transform: scale(1.02);
  }

  .no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e9ecef;
    color: #6c757d;
    font-size: 1.1rem;
    height: 100%;
    min-height: 300px;
    border-radius: 12px;
  }

  .item-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 0.5rem;
  }

  .detail-item {
    margin-bottom: 1.2rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #eaeaea;
  }

  .detail-label {
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 0.3rem;
  }

  .detail-value {
    color: #495057;
    font-size: 1.05rem;
  }

  .status-badge {
    font-size: 0.85rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
  }

  .description-box {
    background-color: #f8f9fa;
    border-left: 4px solid var(--primary-color);
    padding: 1rem 1.5rem;
    border-radius: 0 8px 8px 0;
    margin-top: 0.5rem;
  }

  .action-buttons {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .btn-action {
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .btn-report {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
  }

  .btn-report:hover {
    background-color: #3a5a9f;
    transform: translateY(-2px);
  }

  .btn-contact {
    background-color: white;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
  }

  .btn-contact:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
  }

  @media (max-width: 768px) {

    .item-image,
    .no-image {
      min-height: 250px;
      margin-bottom: 1.5rem;
    }

    .action-buttons {
      flex-direction: column;
    }

    .btn-action {
      width: 100%;
    }
  }
  </style>
</head>

<body>
  <div class="container py-4">

    <!-- Back Button -->
    <a href="{{ route('lost.index') }}" class="btn btn-secondary back-btn mb-4">
      <i class="bi bi-arrow-left me-2"></i>Back to Lost Items
    </a>

    <div class="card shadow-sm">
      <div class="card-body p-4">
        <div class="row">

          <!-- Image Section -->
          <div class="col-md-5 mb-4 mb-md-0">
            @if($item->photo)
            <img src="{{ asset($item->photo) }}" class="item-image w-100" alt="{{ $item->item_name }}">
            @else
            <div class="no-image w-100">
              <div class="text-center">
                <i class="bi bi-image display-4 mb-2 d-block"></i>
                <span>No Image Available</span>
              </div>
            </div>
            @endif
          </div>

          <!-- Details Section -->
          <div class="col-md-7">
            <h1 class="item-title">{{ $item->item_name }}</h1>

            <div class="detail-item">
              <div class="detail-label">Category</div>
              <div class="detail-value">
                <i class="bi bi-tag-fill me-2" style="color: var(--primary-color);"></i>
                {{ $item->category }}
              </div>
            </div>

            <div class="detail-item">
              <div class="detail-label">Location Lost</div>
              <div class="detail-value">
                <i class="bi bi-geo-alt-fill me-2" style="color: var(--danger-color);"></i>
                {{ $item->location_lost }}
              </div>
            </div>

            <div class="detail-item">
              <div class="detail-label">Date Lost</div>
              <div class="detail-value">
                <i class="bi bi-calendar-event me-2" style="color: var(--secondary-color);"></i>
                {{ \Carbon\Carbon::parse($item->date_lost)->format('F j, Y') }}
              </div>
            </div>

            @if($item->description)
            <div class="detail-item">
              <div class="detail-label">Description</div>
              <div class="description-box">
                {{ $item->description }}
              </div>
            </div>
            @endif

            <div class="detail-item">
              <div class="detail-label">Status</div>
              <span
                class="status-badge 
                {{ $item->status == 'lost' ? 'bg-danger' : ($item->status == 'found' ? 'bg-warning text-dark' : 'bg-success') }}">
                <i class="bi 
                  {{ $item->status == 'lost' ? 'bi-exclamation-triangle' : ($item->status == 'found' ? 'bi-check-circle' : 'bi-hand-thumbs-up') }} 
                  me-1"></i>
                {{ ucfirst($item->status) }}
              </span>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
              <button class="btn btn-report btn-action">
                <i class="bi bi-flag me-2"></i>Report Found
              </button>
              <button class="btn btn-contact btn-action">
                <i class="bi bi-envelope me-2"></i>Contact Owner
              </button>
              <button class="btn btn-outline-secondary btn-action">
                <i class="bi bi-share me-2"></i>Share
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Additional Information Section -->
    <div class="card mt-4">
      <div class="card-body">
        <h5 class="card-title mb-3">
          <i class="bi bi-info-circle me-2"></i>Additional Information
        </h5>
        <div class="row">
          <div class="col-md-6">
            <p class="mb-2"><strong>Item ID:</strong> #{{ $item->id }}</p>
            <p class="mb-2"><strong>Reported:</strong> {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
            </p>
          </div>
          <div class="col-md-6">
            <p class="mb-2"><strong>Last Updated:</strong>
              {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}

            </p>
            <p class="mb-0"><strong>Contact:</strong> info@lostandfound.com</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>