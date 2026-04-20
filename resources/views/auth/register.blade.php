@extends('layouts.app')

@section('content')

<style>
    /* 1. Main Container */
    .register-container {
        height: 100vh;
        width: 100%;
        overflow: hidden;
    }

    /* 2. Left Side - Branding (Reusing the same style for consistency) */
    .brand-section {
        /* Using the same image you saved earlier */
        background: linear-gradient(rgba(6, 78, 59, 0.85), rgba(6, 78, 59, 0.95)), 
                    url("{{ asset('images/bg.jpg') }}");
        background-size: cover;
        background-position: center;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px;
        position: relative;
    }

    /* 3. Right Side - Form Area */
    .form-section {
        background: white;
        height: 100vh;
        overflow-y: auto; /* Allows scrolling for longer form */
        padding: 40px;
        display: flex;
        align-items: center; /* Center vertically if screen is tall enough */
        justify-content: center;
    }

    /* Typography */
    .brand-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 3rem;
        line-height: 1.2;
        margin-bottom: 10px;
    }
    
    .urdu-slogan {
        font-family: 'Noto Nastaliq Urdu', serif;
        font-size: 2rem;
        color: #F59E0B; /* Gold */
        margin-bottom: 20px;
    }
    
    .urdu-header {
        font-family: 'Noto Nastaliq Urdu', serif;
        color: #064E3B;
        font-weight: 700;
    }

    /* Form Elements */
    .form-box {
        width: 100%;
        max-width: 450px;
        /* Add some padding at top/bottom for scrolling space */
        padding-top: 20px; 
        padding-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #064E3B;
        margin-bottom: 5px;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
        color: #6b7280;
    }

    .form-control {
        padding: 10px;
        border-left: none; /* Merges with icon */
        border-radius: 0 8px 8px 0;
        border-color: #dee2e6;
        background-color: #f8f9fa;
    }
    
    .form-control:focus {
        background-color: white;
        border-color: #10B981;
        box-shadow: none; /* cleaner look */
        border-left: 1px solid #10B981; /* Restore border on focus */
    }
    
    /* Fix for input group focus border */
    .input-group:focus-within .input-group-text {
        border-color: #10B981;
        background-color: white;
        color: #10B981;
    }

    .btn-register {
        background: #064E3B;
        color: white;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }
    .btn-register:hover {
        background: #10B981;
        transform: translateY(-2px);
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .brand-section { display: none; }
        .form-section {
            background: linear-gradient(135deg, #064E3B 0%, #10B981 100%);
            align-items: flex-start; /* Align top on mobile */
        }
        .form-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-top: 20px;
            margin-bottom: 20px;
        }
    }
</style>

<div class="container-fluid p-0 register-container">
    <div class="row g-0 h-100">
        
        <div class="col-md-7 col-lg-8 brand-section d-none d-md-flex">
            <div>
                <i class="fas fa-users fa-3x mb-4 text-warning"></i>
                <h1 class="brand-title">Join the Network</h1>
                <div class="urdu-slogan">عوام کی آواز</div>
                <p class="lead" style="opacity: 0.8; max-width: 600px;">
                    Register now to become an active part of your community. 
                    File complaints, track progress, and make your voice heard.
                </p>
                <ul class="list-unstyled mt-4" style="font-size: 1.1rem; opacity: 0.9;">
                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i> Real-time tracking</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i> Direct Authority Access</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i> SMS Notifications</li>
                </ul>
            </div>
        </div>

        <div class="col-md-5 col-lg-4 form-section">
            <div class="form-box">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark mb-0">Create Account</h3>
                    <h4 class="urdu-header mt-1">رجسٹر کریں</h4>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm border-0">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="/register" id="registerForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" class="form-control" placeholder="Ali Khan" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">CNIC Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mobile Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" name="phone" class="form-control" placeholder="03xx-xxxxxxx" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Confirm</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-register w-100 mb-3">Register Now</button>

                    <p class="text-center mb-0 text-muted">
                        Already have an account? <a href="/login" class="text-success fw-bold text-decoration-none">Login Here</a>
                    </p>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e){
    let name = this.name.value.trim();
    let cnic = this.cnic.value.trim();
    let phone = this.phone.value.trim();
    let password = this.password.value;
    let confirm = this.password_confirmation.value;

    let cnicPattern = /^\d{5}-\d{7}-\d$/;
    let phonePattern = /^03\d{2}-\d{7}$/;

    if (name.length < 3) {
        alert("Name must be at least 3 characters");
        e.preventDefault();
    }
    if (!cnicPattern.test(cnic)) {
        alert("CNIC must be xxxxx-xxxxxxx-x");
        e.preventDefault();
    }
    if (!phonePattern.test(phone)) {
        alert("Phone must be 03xx-xxxxxxx");
        e.preventDefault();
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        e.preventDefault();
    }
    if (password !== confirm) {
        alert("Passwords do not match");
        e.preventDefault();
    }
});
</script>

@endsection