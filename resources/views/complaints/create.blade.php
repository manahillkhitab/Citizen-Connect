@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary-dark: #064E3B;
        --primary-main: #10B981;
    }
    .form-header {
        background: var(--primary-dark);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    .form-card {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-card">
                
                <div class="form-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2"></i>New Complaint</h4>
                    <span style="font-family: 'Noto Nastaliq Urdu', serif;">شکایت درج کریں</span>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="fw-bold">Select Department <span class="text-danger">*</span></label>
                            <select name="department_id" id="department" class="form-select" required>
                                <option value="">-- Choose Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category" class="form-select" required disabled>
                                <option value="">-- First Select Department --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Brief title of issue" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Complaint Details</label>
                            <textarea name="details" class="form-control" rows="5" placeholder="Describe your issue in detail..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Location / Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Where is the issue located?" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Attachment (Evidence)</label>
                            <input type="file" name="image" class="form-control">
                            <small class="text-muted">Optional. Max size 2MB.</small>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-success btn-lg fw-bold">Submit Complaint</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('department').addEventListener('change', function() {
        var deptId = this.value;
        var categoryDropdown = document.getElementById('category');

        // Reset Dropdown
        categoryDropdown.innerHTML = '<option value="">Loading...</option>';
        categoryDropdown.disabled = true;

        if(deptId) {
            fetch('/get-categories/' + deptId)
                .then(response => response.json())
                .then(data => {
                    categoryDropdown.innerHTML = '<option value="">-- Select Category --</option>';
                    
                    // Populate Categories
                    for (const [id, name] of Object.entries(data)) {
                        let option = document.createElement('option');
                        option.value = id;
                        option.text = name;
                        categoryDropdown.add(option);
                    }
                    categoryDropdown.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    categoryDropdown.innerHTML = '<option value="">Error Loading Categories</option>';
                });
        } else {
            categoryDropdown.innerHTML = '<option value="">-- First Select Department --</option>';
        }
    });
</script>

@endsection