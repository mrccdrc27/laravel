<!-- resources/views/layouts/layout.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            margin-top: 56px; /* Adjust for fixed navbar */
        }

        #sidebar {
            width: 250px;
            position: fixed;
            top: 56px; /* To ensure it starts below the navbar */
            left: 0;
            height: calc(100% - 56px); /* Adjust the height of the sidebar */
            background-color: #b90019;
        }

        #page-content-wrapper {
            margin-left: 250px;
            padding-top: 20px;
            width: 100%;
        }

        .list-group-item-action:hover {
            background-color: #3c98f5;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Certification System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('certificate') }}">Certificate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('search') }}">Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('about') }}">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Wrapper (Sidebar and Content) -->
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-dark text-white">
            <div class="sidebar-header text-center py-4">
                <h3>Panel Title</h3>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('certificate/user') }}" class="list-group-item list-group-item-action bg-dark text-white">User</a>
                <a href="{{ route('certificate/issuer') }}" class="list-group-item list-group-item-action bg-dark text-white">Issuer</a>
                <a href="{{ route('certificate/org') }}" class="list-group-item list-group-item-action bg-dark text-white">Organization</a>
                <a href="{{ route('certificate/create') }}" class="list-group-item list-group-item-action bg-dark text-white">Create</a>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Bundle with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
