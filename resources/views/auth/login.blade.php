@extends('layouts.app')

@section('content')

<style>
    /* 1. The Main Container - Full Height */
    .login-container {
        height: 100vh;
        width: 100%;
        overflow: hidden;
    }

    /* 2. Left Side - The Branding/Image Area */
    .brand-section {
        /* Background Image with Dark Green Overlay */
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

    /* 3. Right Side - The Form Area */
    .form-section {
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        height: 100%;
        overflow-y: auto; /* Allow scroll on small vertical screens */
    }

    /* Typography & Elements */
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

    .form-box {
        width: 100%;
        max-width: 400px;
    }

    .form-control {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }
    .form-control:focus {
        background-color: white;
        border-color: #10B981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .btn-login {
        background: #064E3B;
        color: white;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }
    .btn-login:hover {
        background: #10B981;
        transform: translateY(-2px);
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .brand-section {
            display: none; /* Hide image on mobile for cleaner look */
        }
        .form-section {
            background: linear-gradient(135deg, #064E3B 0%, #10B981 100%);
        }
        .form-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    }
</style>

<div class="container-fluid p-0 login-container">
    <div class="row g-0 h-100">
        
        <div class="col-md-7 col-lg-8 brand-section d-none d-md-flex">
            <div>
                <i class="fas fa-star-and-crescent fa-3x mb-4 text-warning"></i>
                <h1 class="brand-title">Citizen Connect</h1>
                <div class="urdu-slogan">عوام کی آواز</div>
                <p class="lead" style="opacity: 0.8; max-width: 600px;">
                    Welcome to the official grievance redressal portal. 
                    Login to track your complaints and communicate directly with government departments.
                </p>
                <div class="mt-4">
                    <span class="badge bg-light text-dark border p-2 me-2"><i class="fas fa-shield-alt me-1"></i> Secure</span>
                    <span class="badge bg-light text-dark border p-2"><i class="fas fa-bolt me-1"></i> Fast</span>
                </div>
            </div>
        </div>

        <div class="col-md-5 col-lg-4 form-section">
            <div class="form-box">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">Welcome Back</h3>
                    <p class="text-muted">Please enter your details to login</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="/login" id="loginForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">CNIC Number</label>
                        <input type="text" name="cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label small" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="small text-decoration-none text-success fw-bold">Forgot Password?</a>
                    </div>

                    <button class="btn btn-login w-100 mb-3">Login Securely</button>

                    <p class="text-center mt-4">
                        New to Citizen Connect? <br>
                        <a href="/register" class="text-success fw-bold text-decoration-none">Create an Account</a>
                    </p>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e){
    let cnic = this.cnic.value.trim();
    let password = this.password.value;

    let cnicPattern = /^\d{5}-\d{7}-\d$/;

    if (!cnicPattern.test(cnic)) {
        alert("CNIC must be xxxxx-xxxxxxx-x");
        e.preventDefault();
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        e.preventDefault();
    }
});
</script>

@endsection