<div class="flex justify-center">
    <div class="container max-w-7xl px-4 sm:px-6 lg:px-8 col-span-8">
        <x-success-message/>
        {{-- Course Information Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full p-6 container">
            <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                <x-faculty.coursenavbar :course="$course"/>
            </div>         
            {{-- Content goes here --}}
            @php
            use Illuminate\Pagination\LengthAwarePaginator;

            // Define the number of items per page
            $perPage = 10; 
            $currentPage = request()->input('page', 1); // Get the current page or default to 1
            $offset = ($currentPage - 1) * $perPage;

            // Create a paginated collection
            $paginatedAssignments = new LengthAwarePaginator(
                $assignment->slice($offset, $perPage), // Slice the collection for the current page
                $assignment->count(), // Total number of items
                $perPage, // Items per page
                $currentPage, // Current page
                [
                    'path' => request()->url(), // Ensure proper URL structure
                    'query' => request()->query() // Retain query string parameters
                ]
            );
        @endphp

        <div class="col-span-8 relative">
            <div>
                {{ $paginatedAssignments->links() }}
            </div>
            
            @foreach ($paginatedAssignments as $assign)
                <x-faculty.views.submittedassignments :assignment="$assign"/>
                <br>
            @endforeach
            <!-- Render Pagination Links -->
        </div>
        </div>

    </div>
</div>
