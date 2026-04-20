<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Connect</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            dark: '#064E3B',
                            main: '#10B981',
                            light: '#D1FAE5',
                        },
                        accent: '#34D399',
                    }
                }
            }
        }
    </script>
    
    <style>
        :root {
            --primary-dark: #064E3B; /* Emerald 900 */
            --primary-main: #10B981; /* Emerald 500 */
            --primary-light: #D1FAE5; /* Emerald 100 */
            --accent-color: #34D399; /* Emerald 400 */
            --text-dark: #1F2937;
            --bg-color: #F3F4F6;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Figtree', sans-serif;
        }

        /* Layout Wrapper */
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* --- Sidebar --- */
        .sidebar {
            width: 260px;
            background: var(--primary-dark);
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            transition: 0.3s;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-brand {
            padding: 25px;
            font-weight: 700;
            font-size: 1.3rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.1);
        }

        .nav-links {
            list-style: none;
            padding: 20px 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        .nav-item a:hover, .nav-item a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--primary-main);
        }

        .nav-item i { width: 30px; text-align: center; }

        /* --- Main Content --- */
        .main-content {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            height: 100vh;
        }

        /* Utility Classes */
        .card-custom {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: none;
        }
        
        .btn-primary-custom {
            background-color: var(--primary-dark);
            color: white;
            border: none;
        }
        .btn-primary-custom:hover {
            background-color: #043f2e;
            color: white;
        }
    </style>
</head>
<body>

    <div class="dashboard-wrapper">
        @auth
            @include('layouts.sidebar')
        @endauth

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live Search Logic
            const searchForms = document.querySelectorAll('.live-search-form');
            
            searchForms.forEach(form => {
                const inputs = form.querySelectorAll('input, select');
                const targetSelector = form.dataset.target || '.table-responsive';
                let timeout = null;

                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => submitFormAjax(form, targetSelector), 400); // 400ms delay
                    });

                    // For selects, trigger immediately
                    if(input.tagName === 'SELECT') {
                        input.addEventListener('change', () => submitFormAjax(form, targetSelector));
                    }
                });
            });

            function submitFormAjax(form, targetSelector) {
                const url = new URL(form.action);
                const formData = new FormData(form);
                const params = new URLSearchParams(formData);
                
                // Add params to URL
                url.search = params.toString();

                // Fetch Update
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector(targetSelector);
                    const currentContainer = document.querySelector(targetSelector);

                    if (newContent && currentContainer) {
                        currentContainer.innerHTML = newContent.innerHTML;
                    }
                })
                .catch(err => console.error('Live Search Error:', err));
            }
        });
    </script>
</body>
</html>
