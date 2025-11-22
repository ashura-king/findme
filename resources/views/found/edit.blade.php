@extends('layouts.app')

@section('title', 'Edit Found Item — Lost & Found')

@section('header-actions')
<div class="d-flex gap-2">
  <a href="{{ route('found.show', $item->id) }}" class="btn btn-outline-light">
    <i class="fas fa-arrow-left me-1"></i>Back to Item
  </a>
</div>
@endsection

@push('styles')
<!-- Use the same styles as create form -->
<style>
.report-form-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem 0;
}

.form-card {
  background: var(--card-bg);
  border-radius: 20px;
  padding: 3rem;
  box-shadow: var(--shadow-lg);
  border: 1px solid var(--border-color);
  position: relative;
  overflow: hidden;
}

.form-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 6px;
  background: linear-gradient(90deg, var(--warning-color), #f59e0b);
}

.form-header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.form-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, var(--warning-color), #f59e0b);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  color: white;
  font-size: 2rem;
  box-shadow: var(--shadow-lg);
}

.form-title {
  color: var(--text-primary);
  font-weight: 700;
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.form-subtitle {
  color: var(--text-secondary);
  font-size: 1.1rem;
}

/* Rest of the form styles from create form */
.form-group {
  margin-bottom: 2rem;
  position: relative;
}

.form-label {
  display: block;
  margin-bottom: 0.75rem;
  color: var(--text-primary);
  font-weight: 600;
  font-size: 1rem;
}

.form-label .required {
  color: var(--danger-color);
  margin-left: 4px;
}

.form-input,
.form-textarea,
.form-select,
.form-file {
  width: 100%;
  padding: 1rem 1.25rem;
  border: 2px solid var(--border-color);
  border-radius: 12px;
  background: var(--card-bg);
  color: var(--text-primary);
  font-size: 1rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  outline: none;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
  border-color: var(--warning-color);
  box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
  transform: translateY(-2px);
}

.form-textarea {
  resize: vertical;
  min-height: 120px;
  line-height: 1.6;
}

.form-file {
  padding: 1.5rem 1.25rem;
  border: 2px dashed var(--border-color);
  background: var(--light-bg);
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

.form-file:hover {
  border-color: var(--warning-color);
  background: rgba(245, 158, 11, 0.05);
}

.file-label {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: var(--text-secondary);
  cursor: pointer;
}

.file-label i {
  font-size: 2rem;
  color: var(--warning-color);
  margin-bottom: 0.5rem;
}

.file-name {
  margin-top: 0.5rem;
  color: var(--warning-color);
  font-weight: 600;
  font-size: 0.9rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
  margin-top: 2.5rem;
  padding-top: 2rem;
  border-top: 1px solid var(--border-color);
}

.btn-submit {
  background: linear-gradient(135deg, var(--warning-color), #f59e0b);
  color: white;
  border: none;
  padding: 1rem 2.5rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  box-shadow: var(--shadow-md);
}

.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
  background: linear-gradient(135deg, #f59e0b, var(--warning-color));
}

.btn-cancel {
  background: var(--light-bg);
  color: var(--text-secondary);
  border: 2px solid var(--border-color);
  padding: 1rem 2rem;
  border-radius: 12px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-cancel:hover {
  background: var(--border-color);
  color: var(--text-primary);
  transform: translateY(-1px);
}

.current-photo {
  text-align: center;
  margin-bottom: 1rem;
}

.current-photo img {
  max-width: 200px;
  border-radius: 8px;
}

@media (max-width: 768px) {
  .report-form-container {
    padding: 1rem;
  }

  .form-card {
    padding: 2rem 1.5rem;
    border-radius: 16px;
  }

  .form-row {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}
</style>
@endpush

@section('content')
<div class="container-fluid">
  <div class="report-form-container">
    <div class="form-card">
      <div class="form-header">
        <div class="form-icon">
          <i class="fas fa-edit"></i>
        </div>
        <h1 class="form-title">Edit Found Item</h1>
        <p class="form-subtitle">Update the details of this found item</p>
      </div>

      <form action="{{ route('found.update', $item->id) }}" method="POST" enctype="multipart/form-data"
        id="foundItemForm">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="item_name" class="form-label">
            Item Name <span class="required">*</span>
          </label>
          <input type="text" id="item_name" name="item_name" class="form-input"
            placeholder="e.g., iPhone 13, Black Wallet, Car Keys" required
            value="{{ old('item_name', $item->item_name) }}">
        </div>

        <div class="form-group">
          <label for="category" class="form-label">
            Category <span class="required">*</span>
          </label>
          <select id="category" name="category" class="form-select" required>
            <option value="">Select a category</option>
            <option value="electronics" {{ old('category', $item->category) == 'electronics' ? 'selected' : '' }}>📱
              Electronics</option>
            <option value="documents" {{ old('category', $item->category) == 'documents' ? 'selected' : '' }}>📄
              Documents</option>
            <option value="accessories" {{ old('category', $item->category) == 'accessories' ? 'selected' : '' }}>👓
              Accessories</option>
            <option value="clothing" {{ old('category', $item->category) == 'clothing' ? 'selected' : '' }}>👕 Clothing
            </option>
            <option value="bags" {{ old('category', $item->category) == 'bags' ? 'selected' : '' }}>🎒 Bags & Backpacks
            </option>
            <option value="keys" {{ old('category', $item->category) == 'keys' ? 'selected' : '' }}>🔑 Keys</option>
            <option value="jewelry" {{ old('category', $item->category) == 'jewelry' ? 'selected' : '' }}>💍 Jewelry
            </option>
            <option value="other" {{ old('category', $item->category) == 'other' ? 'selected' : '' }}>📦 Other</option>
          </select>
        </div>

        <div class="form-group">
          <label for="description" class="form-label">
            Description
          </label>
          <textarea id="description" name="description" class="form-textarea"
            placeholder="Provide detailed description including color, size, brand, distinguishing features, contents..."
            rows="4">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="location_found" class="form-label">
              Where Found? <span class="required">*</span>
            </label>
            <input type="text" id="location_found" name="location_found" class="form-input"
              placeholder="e.g., Central Park, Coffee Shop, Bus Station" required
              value="{{ old('location_found', $item->location_found) }}">
          </div>

          <div class="form-group">
            <label for="date_found" class="form-label">
              Date Found <span class="required">*</span>
            </label>
            <input type="date" id="date_found" name="date_found" class="form-input" required
              value="{{ old('date_found', $item->date_found->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="finder_name" class="form-label">
              Finder Name <span class="required">*</span>
            </label>
            <input type="text" id="finder_name" name="finder_name" class="form-input"
              placeholder="Enter finder's full name" required value="{{ old('finder_name', $item->finder_name) }}">
          </div>

          <div class="form-group">
            <label for="finder_contact" class="form-label">
              Contact Information <span class="required">*</span>
            </label>
            <input type="text" id="finder_contact" name="finder_contact" class="form-input"
              placeholder="Phone number or email" required value="{{ old('finder_contact', $item->finder_contact) }}">
          </div>
        </div>

        <div class="form-group">
          <label for="status" class="form-label">
            Status <span class="required">*</span>
          </label>
          <select id="status" name="status" class="form-select" required>
            <option value="found" {{ old('status', $item->status) == 'found' ? 'selected' : '' }}>Found</option>
            <option value="returned" {{ old('status', $item->status) == 'returned' ? 'selected' : '' }}>Returned
            </option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Item Photo</label>

          @if($item->photo)
          <div class="current-photo">
            <p class="form-hint">Current Photo:</p>
            <img src="{{ asset('storage/' . $item->photo) }}" alt="Current photo" class="img-thumbnail">
          </div>
          @endif

          <div class="form-file" id="fileUploadArea">
            <label class="file-label">
              <i class="fas fa-cloud-upload-alt"></i>
              <span>Click to upload a new photo or drag and drop</span>
              <span class="form-hint">PNG, JPG, JPEG up to 5MB</span>
            </label>
            <input type="file" name="photo" id="photo" accept="image/*">
            <div class="file-name" id="fileName"></div>
          </div>
        </div>

        <div class="form-actions">
          <a href="{{ route('found.show', $item->id) }}" class="btn-cancel">
            <i class="fas fa-times"></i>
            Cancel
          </a>
          <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i>
            Update Found Item
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // File upload handling (same as create form)
  const fileInput = document.getElementById('photo');
  const fileUploadArea = document.getElementById('fileUploadArea');
  const fileName = document.getElementById('fileName');

  fileUploadArea.addEventListener('click', () => fileInput.click());

  fileUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileUploadArea.style.borderColor = 'var(--warning-color)';
    fileUploadArea.style.background = 'rgba(245, 158, 11, 0.1)';
  });

  fileUploadArea.addEventListener('dragleave', () => {
    fileUploadArea.style.borderColor = 'var(--border-color)';
    fileUploadArea.style.background = 'var(--light-bg)';
  });

  fileUploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    fileInput.files = e.dataTransfer.files;
    updateFileName();
  });

  fileInput.addEventListener('change', updateFileName);

  function updateFileName() {
    if (fileInput.files.length > 0) {
      fileName.textContent = fileInput.files[0].name;
      fileUploadArea.style.borderColor = 'var(--success-color)';
      fileUploadArea.style.background = 'rgba(16, 185, 129, 0.1)';
    } else {
      fileName.textContent = '';
      fileUploadArea.style.borderColor = 'var(--border-color)';
      fileUploadArea.style.background = 'var(--light-bg)';
    }
  }

  // Set max date to today for date found
  const dateInput = document.getElementById('date_found');
  const today = new Date().toISOString().split('T')[0];
  dateInput.max = today;
});
</script>
@endpush