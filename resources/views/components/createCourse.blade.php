<html>

<div class="container">
    <h1>Create a New Course</h1>
     
    <!-- Success Message -->
     @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('components.createCourse') }}" method="POST">
        @csrf
        <div>
            <label for="title">Course Name:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="description">Course Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <button type="submit">Create Course</button>
    </form>
</div>
</html>
