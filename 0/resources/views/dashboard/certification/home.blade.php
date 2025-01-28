@extends('layout.layout')
@section('content')
<x-user-info :userinfo="$userinfo" />
<x-cert :cert="$cert" />
<x-org :org="$org" />
<x-issuer :issuer="$issuer" />

{{-- @include('table.cert')
@include('table.user')
@include('table.issuer')
@include('table.org')
@include('table.script') --}}
@endsection



