@extends('layout.layout')

@section('content')
    <div class="alert alert-danger">
        <h4 class="alert-heading">Something Went Wrong</h4>
        <p>We're sorry, but an error occurred. Please try again later.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
    </div>
@endsection
