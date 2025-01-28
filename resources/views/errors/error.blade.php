@extends('layout.layout')

@section('content')
    <div class="alert alert-warning">
        <h4 class="alert-heading">Certificate Not Found</h4>
        <p>The certificate with ID {{ $certificateId }} does not exist or has been deleted.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Return to Certificates</a>
    </div>
@endsection