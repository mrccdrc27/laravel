<!DOCTYPE html>
<html lang="en">

<!-- https://getbootstrap.com/docs/5.2/getting-started/introduction/ -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certify</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #3A7CA5;
            --secondary-color: #578E7E;
            --light-color: #FFFAEC;
            --dark-color: #2C3E50;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F4F6F9;
            color: var(--dark-color);
        }

        .navbar-custom {
            background-color: var(--primary-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--light-color);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--light-color);
            font-weight: 700;
        }

        .content-wrapper {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        @media (prefers-reduced-motion: no-preference) {
            .navbar-nav .nav-item {
                transition: transform 0.3s ease;
            }

            .navbar-nav .nav-item:hover {
                transform: scale(1.05);
            }
        }

        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.8);
            padding: 0.25rem 0.5rem;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-collapse {
            background-color: var(--primary-color);
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                padding: 1rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 999;
                background-color: var(--primary-color);
            }

            .navbar-nav {
                padding: 0.5rem 0;
            }

            .nav-item {
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ route('home') }}">
                <i class="bi bi-award me-2"></i>Certify
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('org') ? 'active' : '' }}"
                            href="{{ route('org') }}">Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('certifications.create') ? 'active' : '' }}"
                            href="{{ route('certifications.create') }}">
                            Create Certificate
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('api-doc') ? 'active' : '' }}"
                            href="{{ route('api-doc') }}">API Documentation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('certificates.search') ? 'active' : '' }}"
                            href="{{ route('certificates.search') }}">Search</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS (Bundle with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
