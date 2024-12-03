<!-- resources/views/toys.blade.php -->
<h1>core List</h1>
<ul>
    @foreach($core as $cor)
        <li>{{ $cor->model }} - ${{ $cor->manufacturer }}</li>
    @endforeach
</ul>
