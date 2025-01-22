@extends('layout.layout')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Organizations</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $data['orgCount'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Users</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $data['userinfoCount'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5>Certifications</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $data['certCount'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5>Issuers</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $data['issuerCount'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@endsection