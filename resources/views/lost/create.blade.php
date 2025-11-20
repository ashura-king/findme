@extends('layouts.app')

@section('title', 'Report Lost Item — Lost & Found')

@section('header-actions')
<div class="d-flex gap-2">
  <a href="{{ route('lost.index') }}" class="btn btn-outline-light">
    <i class="fas fa-arrow-left me-1"></i>Back to Lost Items
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
  background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
}

.form-header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.form-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
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
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  transform: translateY(-2px);
}

.form-input::placeholder,
.form-textarea::placeholder {
  color: var(--text-muted);
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
  border-color: var(--primary-color);
  background: rgba(99, 102, 241, 0.05);
}

.form-file input[type="file"] {
  display: none;
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
  color: var(--primary-color);
  margin-bottom: 0.5rem;
}

.file-name {
  margin-top: 0.5rem;
  color: var(--primary-color);
  font-weight: 600;
  font-size: 0.9rem;
}

.form-select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236466f1'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 1rem center;
  background-size: 1.5rem;
}

.form-hint {
  display: block;
  margin-top: 0.5rem;
  color: var(--text-muted);
  font-size: 0.875rem;
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
  background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
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
  background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
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

/* Error states */
.form-input.error,
.form-textarea.error,
.form-select.error {
  border-color: var(--danger-color);
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.error-message {
  color: var(--danger-color);
  font-size: 0.875rem;
  margin-top: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Success state */
.form-input.success,
.form-textarea.success,
.form-select.success {
  border-color: var(--success-color);
  box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Responsive Design */
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

  .form-actions {
    flex-direction: column-reverse;
  }

  .btn-submit,
  .btn-cancel {
    width: 100%;
    justify-content: center;
  }

  .form-title {
    font-size: 1.75rem;
  }
}

/* Animation for form elements */
@keyframes slideInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.form-group {
  animation: slideInUp 0.5s ease-out forwards;
}

.form-group:nth-child(1) {
  animation-delay: 0.1s;
}

.form-group:nth-child(2) {
  animation-delay: 0.2s;
}

.form-group:nth-child(3) {
  animation-delay: 0.3s;
}

.form-group:nth-child(4) {
  animation-delay: 0.4s;
}

.form-group:nth-child(5) {
  animation-delay: 0.5s;
}

.form-group:nth-child(6) {
  animation-delay: 0.6s;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
  <div class="report-form-container">
    <div class="form-card">
      <div class="form-header">
        <div class="form-icon">
          <i class="fas fa-binoculars"></i>
        </div>
        <h1 class="form-title">Report Lost Item</h1>
        <p class="form-subtitle">Help us reunite you with your lost belongings</p>
      </div>

      <form action="{{ route('lost.store') }}" method="POST" enctype="multipart/form-data" id="lostItemForm">
        @csrf

        <div class="form-group">
          <label for="item_name" class="form-label">
            Item Name <span class="required">*</span>
          </label>
          <input type="text" id="item_name" name="item_name" class="form-input"
            placeholder="e.g., iPhone 13, Black Wallet, Car Keys" required value="{{ old('item_name') }}">
          <span class="form-hint">Be specific about the item name and key features</span>
        </div>

        <div class="form-group">
          <label for="category" class="form-label">
            Category <span class="required">*</span>
          </label>
          <select id="category" name="category" class="form-select" required>
            <option value="">Select a category</option>
            <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>📱 Electronics</option>
            <option value="documents" {{ old('category') == 'documents' ? 'selected' : '' }}>📄 Documents</option>
            <option value="accessories" {{ old('category') == 'accessories' ? 'selected' : '' }}>👓 Accessories</option>
            <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>👕 Clothing</option>
            <option value="bags" {{ old('category') == 'bags' ? 'selected' : '' }}>🎒 Bags & Backpacks</option>
            <option value="keys" {{ old('category') == 'keys' ? 'selected' : '' }}>🔑 Keys</option>
            <option value="jewelry" {{ old('category') == 'jewelry' ? 'selected' : '' }}>💍 Jewelry</option>
            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>📦 Other</option>
          </select>
        </div>

        <div class="form-group">
          <label for="description" class="form-label">
            Description
          </label>
          <textarea id="description" name="description" class="form-textarea"
            placeholder="Provide detailed description including color, size, brand, distinguishing features, contents...">{{ old('description') }}</textarea>
          <span class="form-hint">The more details you provide, the better chance of recovery</span>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="location_lost" class="form-label">
              Where Lost? <span class="required">*</span>
            </label>
            <input type="text" id="location_lost" name="location_lost" class="form-input"
              placeholder="e.g., Central Park, Coffee Shop, Bus Station" required value="{{ old('location_lost') }}">
          </div>

          <div class="form-group">
            <label for="date_lost" class="form-label">
              Date Lost <span class="required">*</span>
            </label>
            <input type="date" id="date_lost" name="date_lost" class="form-input" required
              value="{{ old('date_lost') }}">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Item Photo</label>
          <div class="form-file" id="fileUploadArea">
            <label class="file-label">
              <i class="fas fa-cloud-upload-alt"></i>
              <span>Click to upload a photo or drag and drop</span>
              <span class="form-hint">PNG, JPG, JPEG up to 5MB</span>
            </label>
            <input type="file" name="photo" id="photo" accept="image/*">
            <div class="file-name" id="fileName"></div>
          </div>
        </div>

        <div class="form-actions">
          <a href="{{ route('lost.index') }}" class="btn-cancel">
            <i class="fas fa-times"></i>
            Cancel
          </a>
          <button type="submit" class="btn-submit">
            <i class="fas fa-paper-plane"></i>
            Report Lost Item
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
  // File upload handling
  const fileInput = document.getElementById('photo');
  const fileUploadArea = document.getElementById('fileUploadArea');
  const fileName = document.getElementById('fileName');

  fileUploadArea.addEventListener('click', () => fileInput.click());

  fileUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileUploadArea.style.borderColor = 'var(--primary-color)';
    fileUploadArea.style.background = 'rgba(99, 102, 241, 0.1)';
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


  const form = document.getElementById('lostItemForm');
  const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

  inputs.forEach(input => {
    input.addEventListener('blur', validateField);
    input.addEventListener('input', clearError);
  });

  function validateField(e) {
    const field = e.target;
    if (!field.value.trim()) {
      showError(field, 'This field is required');
    } else {
      clearError(field);
    }
  }

  function showError(field, message) {
    field.classList.add('error');
    field.classList.remove('success');

    let errorElement = field.parentNode.querySelector('.error-message');
    if (!errorElement) {
      errorElement = document.createElement('div');
      errorElement.className = 'error-message';
      field.parentNode.appendChild(errorElement);
    }
    errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
  }

  function clearError(e) {
    const field = e.target || e;
    field.classList.remove('error');
    field.classList.add('success');

    const errorElement = field.parentNode.querySelector('.error-message');
    if (errorElement) {
      errorElement.remove();
    }
  }


  const dateInput = document.getElementById('date_lost');
  const today = new Date().toISOString().split('T')[0];
  dateInput.max = today;


  const description = document.getElementById('description');
  const charCount = document.createElement('div');
  charCount.className = 'form-hint';
  charCount.style.textAlign = 'right';
  charCount.style.marginTop = '0.5rem';
  description.parentNode.appendChild(charCount);

  description.addEventListener('input', function() {
    const count = this.value.length;
    charCount.textContent = `${count} characters`;

    if (count > 500) {
      charCount.style.color = 'var(--warning-color)';
    } else {
      charCount.style.color = 'var(--text-muted)';
    }
  });
});
</script>
@endpush