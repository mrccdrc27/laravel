{{-- working --}}

<div id="issuer-container">
    <p>Are you sure you want to delete this issuer?</p>
    
    @php
        $delete = 7;
    @endphp

    <form action="{{ url('/api/faculty/' . $delete) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>