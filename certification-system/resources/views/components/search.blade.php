<form method="GET" action="{{ url('/api/cert') }}/{{ old('cert_id') }}" class="mb-4">
    <div class="row">
        <div class="col-md-8">
            <input 
                type="text" 
                id="cert_id" 
                class="form-control" 
                placeholder="Enter Certification ID"
                value="{{ old('cert_id') }}"
                required
                oninput="this.form.action='{{ url('/api/cert') }}/'+this.value"
            >
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </div>
</form>
