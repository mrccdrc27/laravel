<!-- resources/views/toys.blade.php -->
<h1>Toy List</h1>
<h1>test</h1>
<ul>
    @foreach($toys as $toy)
        <li>{{ $toy->name }} - ${{ $toy->price }}</li>
    @endforeach
</ul>


