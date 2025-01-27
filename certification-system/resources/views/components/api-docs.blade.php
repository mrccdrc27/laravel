{{-- Create a new file: resources/views/components/api-docs.blade.php --}}
@props([
    'method',
    'endpoint',
    'requestExample',
    'responseExample',
    'parameters' => null
])

<div class="row g-4 mb-4">
    {{-- Request Column --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <span class="badge bg-secondary me-2">{{ $method }}</span>
                    {{ $endpoint }}
                </h5>
            </div>
            <div class="card-body">
                @if($parameters)
                    <div class="mb-3">
                        <h6 class="fw-bold">Required Parameters:</h6>
                        <ul class="list-unstyled">
                            @foreach($parameters as $param => $desc)
                                <li class="mb-2">
                                    <code>{{ $param }}</code>: {{ $desc }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="code-block">
                    <pre class="text-white m-0">{{ $requestExample }}</pre>
                </div>
            </div>
        </div>
    </div>

    {{-- Response Column --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">Response</h5>
            </div>
            <div class="card-body">
                <div class="code-block">
                    <pre class="text-white m-0">{{ $responseExample }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>