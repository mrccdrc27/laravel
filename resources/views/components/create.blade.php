@extends('layout.layout')
@section('content')
    <style>
        /* Form Container Styles */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Section Styles */
        .form-section {
            background-color: #F4F6F9;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        /* Form Group Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(58, 124, 165, 0.1);
            outline: none;
        }

        /* Form Row Layout */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* Error Message Styles */
        .error-message {
            color: #DC2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Button Styles */
        .btn-submit {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #2B5D7C;
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            background-color: #94A3B8;
            cursor: not-allowed;
            transform: none;
        }

        /* Loading State */
        .loading {
            margin-left: 1rem;
            color: var(--secondary-color);
            font-size: 0.875rem;
        }

        /* Textarea Styles */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
    </style>

<div class="form-container">
    <h1 class="section-title">Create Certificate</h1>

    <form id="certificateForm" method="POST" action="{{ route('web.certificates.store') }}">
        @csrf

        <div class="form-section">
            <h2 class="section-title">Recipient Information</h2>
            <div class="form-group">
                <label for="name" class="form-label">Recipient's Name <span class="text-muted">(Optional)</span></label>
                <input type="text" class="form-control" id="name" name="name">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h2 class="section-title">Course Information</h2>
            <div class="form-group">
                <label for="courseName" class="form-label">Course Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="courseName" name="courseName" required>
                @error('courseName')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="courseDescription" class="form-label">Course Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="courseDescription" name="courseDescription" rows="3" required></textarea>
                @error('courseDescription')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h2 class="section-title">Certificate Details</h2>
            <div class="form-group">
                <label for="title" class="form-label">Certificate Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Certificate Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="issuedAt" class="form-label">Issue Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" id="issuedAt" name="issuedAt" required>
                    @error('issuedAt')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-col">
                    <label for="expiryDate" class="form-label">Expiry Date (Optional)</label>
                    <input type="date" class="form-control" id="expiryDate" name="expiryDate">
                    @error('expiryDate')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-submit">Create Certificate</button>
            <span class="loading" style="display: none;">Creating certificate...</span>
        </div>
    </form>
</div>

<script>
    document.getElementById('certificateForm').addEventListener('submit', function(e) {
        const loading = document.querySelector('.loading');
        const submitBtn = document.querySelector('.btn-submit');

        loading.style.display = 'inline'; // Show loading text
        submitBtn.disabled = true; // Disable button to prevent multiple clicks
    });

    // Set default issue date to current date and time
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset()); // Adjust for timezone
        document.getElementById('issuedAt').value = now.toISOString().slice(0, 16);
    });
</script>
@endsection
