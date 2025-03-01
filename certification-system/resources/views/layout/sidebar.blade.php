<!-- resources/views/layouts/sidebar.blade.php -->

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar">
        <div class="sidebar-header text-center py-4">
            <h3>Panel Title</h3>
        </div>
        <div class="list-group list-group-flush">
            <div class="list-group list-group-flush">
                <a href="{{ route('certificate/user') }}" class="list-group-item list-group-item-action bg-dark text-white">User</a>
                <a href="{{ route('certificate/issuer') }}" class="list-group-item list-group-item-action bg-dark text-white">Issuer</a>
                <a href="{{ route('certificate/org') }}" class="list-group-item list-group-item-action bg-dark text-white">Organization</a>
                <a href="{{ route('certificate/create') }}" class="list-group-item list-group-item-action bg-dark text-white">Create</a>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>

<!-- Add Bootstrap JS and CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<style>
    #wrapper {
        display: flex;
        width: 100%;
        height: 100vh;
    }

    #sidebar {
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        padding-top: 20px;
    }

    #page-content-wrapper {
        width: 100%;
        margin-left: 250px;
    }

    .list-group-item-action:hover {
        background-color: #343a40;
    }
</style>
