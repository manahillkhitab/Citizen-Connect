<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Connect – عوام کی آواز</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-dark: #064E3B;  /* Deep Emerald */
            --primary-main: #10B981;  /* Vibrant Green */
            --accent-gold: #F59E0B;   /* Amber */
            --light-bg: #ECFDF5;      /* Minty White */
            --text-dark: #1F2937;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* --- URDU FONT STYLING --- */
        .urdu-text {
            font-family: 'Noto Nastaliq Urdu', serif;
            font-weight: 700; /* Nastaliq looks better bold */
            line-height: 1.6; /* Needs more height */
            vertical-align: middle;
        }

        /* --- Glassmorphism Navbar --- */
        .navbar {
            background-color: rgba(6, 78, 59, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
        }

        .btn-login {
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50px;
            padding: 8px 25px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: white;
            color: var(--primary-dark);
        }

        .btn-signup {
            background: var(--accent-gold);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            transition: 0.3s;
        }
        .btn-signup:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        /* --- Hero Section --- */
        .hero {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.95) 0%, rgba(16, 185, 129, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1577563908411-5077b6dc7624?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover;
            background-position: center;
            height: 90vh;
            color: white;
            position: relative;
            padding-top: 80px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        
        .hero-badge {
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.3);
            gap: 10px;
        }

        /* --- Stats Strip --- */
        .stats-strip {
            background: white;
            margin-top: -60px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            z-index: 2;
            padding: 30px;
        }

        .stat-item h3 {
            font-weight: 700;
            color: var(--primary-main);
            margin: 0;
        }
        .stat-item p {
            color: #6b7280;
            font-size: 0.9rem;
            margin: 0;
        }

        /* --- Features & How It Works --- */
        .feature-card {
            border: none;
            border-radius: 20px;
            background: white;
            padding: 40px 30px;
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: var(--light-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-dark);
            margin-bottom: 25px;
            transition: 0.3s;
        }
        
        .feature-card:hover .icon-circle {
            background: var(--primary-main);
            color: white;
        }

        .step-number {
            font-size: 4rem;
            font-weight: 800;
            color: rgba(16, 185, 129, 0.15);
            line-height: 1;
            position: absolute;
            top: -20px;
            right: 20px;
        }

        /* --- Footer --- */
        footer {
            background: var(--primary-dark);
            color: rgba(255,255,255,0.7);
            padding-top: 60px;
        }
        footer h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
        }
        footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: 0.3s;
        }
        footer a:hover {
            color: var(--accent-gold);
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.2rem; }
            .stats-strip { margin-top: 20px; }
            .navbar-brand { font-size: 1.1rem; }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-star-and-crescent me-2 text-warning"></i>
            <div>
                Citizen Connect
                <span class="urdu-text ms-2 border-start ps-2 border-light" style="font-size: 1.1em; opacity: 0.9;">عوام کی آواز</span>
            </div>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars text-white fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item me-3"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item mt-2 mt-lg-0 me-2">
                    <a href="/login" class="btn btn-login">Login</a>
                </li>
                <li class="nav-item mt-2 mt-lg-0">
                    <a href="/register" class="btn btn-signup">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero d-flex align-items-center text-center text-lg-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center fade-in-up">
                
                <div class="hero-badge">
                    <i class="fas fa-check-circle text-warning"></i> 
                    <span>Official Complaint Portal</span>
                    <span class="mx-1">•</span>
                    <span class="urdu-text" style="font-size: 1.2em;">عوام کی آواز</span>
                </div>

                <h1>Empowering Citizens,<br>Resolving Issues.</h1>
                <p class="lead mb-4" style="color: rgba(255,255,255,0.9);">
                    The bridge between the public and the government. Report issues, track progress, and help build a better community.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="/register" class="btn btn-signup btn-lg px-5">File a Complaint</a>
                    <a href="#how-it-works" class="btn btn-login btn-lg px-5">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="stats-strip fade-in-up delay-1">
        <div class="row text-center">
            <div class="col-md-4 border-end border-light">
                <div class="stat-item p-3">
                    <i class="fas fa-users fa-2x mb-2 text-muted"></i>
                    <h3>50,000+</h3>
                    <p>Registered Citizens</p>
                </div>
            </div>
            <div class="col-md-4 border-end border-light">
                <div class="stat-item p-3">
                    <i class="fas fa-check-double fa-2x mb-2 text-muted"></i>
                    <h3>85%</h3>
                    <p>Resolution Rate</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item p-3">
                    <i class="fas fa-clock fa-2x mb-2 text-muted"></i>
                    <h3>24-48 Hrs</h3>
                    <p>Avg. Response Time</p>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="how-it-works" class="py-5 mt-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-success fw-bold text-uppercase">Simple Process</h6>
            <h2 class="fw-bold display-6">How It Works</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 text-center position-relative">
                    <span class="step-number">01</span>
                    <img src="https://cdn-icons-png.flaticon.com/512/3585/3585145.png" alt="Register" style="width: 80px; margin: 0 auto;">
                    <h4 class="mt-4 fw-bold">Register & Login</h4>
                    <p class="text-muted">Create your account using your CNIC and mobile number to verify your identity.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 text-center position-relative">
                    <span class="step-number">02</span>
                    <img src="https://cdn-icons-png.flaticon.com/512/10695/10695034.png" alt="Submit" style="width: 80px; margin: 0 auto;">
                    <h4 class="mt-4 fw-bold">Submit Complaint</h4>
                    <p class="text-muted">Select the department, describe the issue, attach photos, and pin the location.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 text-center position-relative">
                    <span class="step-number">03</span>
                    <img src="https://cdn-icons-png.flaticon.com/512/4127/4127281.png" alt="Track" style="width: 80px; margin: 0 auto;">
                    <h4 class="mt-4 fw-bold">Get Resolved</h4>
                    <p class="text-muted">Track real-time status updates and receive notification upon resolution.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="features" class="py-5" style="background: var(--light-bg)">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-success fw-bold text-uppercase">Why Choose Us</h6>
            <h2 class="fw-bold display-6">Key Features</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4 fade-in-up">
                <div class="feature-card shadow-sm">
                    <div class="icon-circle">
                        <i class="fas fa-map-marked-alt fa-2x"></i>
                    </div>
                    <h5>Geo-Tagging</h5>
                    <p class="text-muted">Accurately pin-point the location of the issue using Google Maps integration.</p>
                </div>
            </div>
            <div class="col-md-4 fade-in-up delay-1">
                <div class="feature-card shadow-sm">
                    <div class="icon-circle">
                        <i class="fas fa-bell fa-2x"></i>
                    </div>
                    <h5>Real-time Alerts</h5>
                    <p class="text-muted">Get SMS and Email notifications immediately when status changes.</p>
                </div>
            </div>
            <div class="col-md-4 fade-in-up delay-2">
                <div class="feature-card shadow-sm">
                    <div class="icon-circle">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h5>Secure & Private</h5>
                    <p class="text-muted">Your data is encrypted. You can also file complaints anonymously.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h3 class="text-white fw-bold mb-3">
                    <i class="fas fa-star-and-crescent me-2"></i>Citizen Connect
                </h3>
                <h5 class="urdu-text text-warning">عوام کی آواز</h5>
                <p class="small mt-3">The official government portal for citizen grievance redressal. We are committed to transparency and efficiency.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#">Home</a></li>
                    <li class="mb-2"><a href="#">About Us</a></li>
                    <li class="mb-2"><a href="#">FAQs</a></li>
                    <li class="mb-2"><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Contact</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-phone me-2 text-warning"></i> +92 123 4567890</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-warning"></i> help@citizenconnect.pk</li>
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-warning"></i> Islamabad, Pakistan</li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Get the App</h5>
                <p class="small">Download our mobile app for easier access.</p>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-light btn-sm"><i class="fab fa-apple"></i> App Store</button>
                    <button class="btn btn-outline-light btn-sm"><i class="fab fa-google-play"></i> Play Store</button>
                </div>
            </div>
        </div>
        <hr style="border-color: rgba(255,255,255,0.1);">
        <div class="text-center pt-3 small text-muted">
            © 2025 Citizen Connect – <span class="urdu-text">عوام کی آواز</span>. All Rights Reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>