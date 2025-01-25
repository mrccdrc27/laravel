<div class="flex justify-center">
    <div class="container max-w-7xl px-4 sm:px-6 lg:px-8 col-span-8">
        <x-success-message/>
        {{-- Course Information Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full p-6 container">
            <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                <x-faculty.coursenavbar :course="$course"/>
            </div>         
            {{-- Content goes here --}}
            <div class="col-span-8 relative">
                <div x-data="{ visibleCount: 3, totalCount: {{ count($assignment) }} }">
                    @foreach ($assignment as $index => $assign)
                        <div x-show="{{ $index }} < visibleCount" class="mb-4">
                            <x-faculty.views.assignments :assignment="$assign" :course="$course"/>
                        </div>
                    @endforeach
                    
                    <div class="text-center mt-4" x-show="visibleCount < totalCount">
                        <button @click="visibleCount += 3" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">
                            Load More
                        </button>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</div>
