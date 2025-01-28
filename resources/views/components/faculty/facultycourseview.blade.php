<div class="flex justify-center">
    <div class="container max-w-7xl px-4 sm:px-6 lg:px-8 col-span-8">
        <x-success-message/>

        {{-- Course Information Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full p-6 container">
            
            <!-- Course Navbar -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-white p-6 rounded-lg shadow-md relative">
                <x-faculty.coursenavbar :course="$course"/>
            </div>

            {{-- Faculty: Class Code --}}
            @if (Auth::user()->hasRole('faculty'))
                {{-- Course Code Card --}}
                <div class="col-span-1 sm:col-span-2 lg:col-span-1 bg-white p-4 rounded-lg shadow-md transform hover:scale-105 transition-all duration-300 ease-in-out hover:shadow-xl">
                    <h2 class="text-xl font-semibold mb-2">{{$course->courseID}}</h2>
                    <p class="text-gray-600">Your course code here</p>
                </div>
            @endif

            {{-- Class Title Card --}}
            <div class="col-span-1 sm:col-span-2 lg:col-span-2 bg-white p-6 rounded-lg shadow-md relative">
                <!-- Course Content -->
                <h2 class="text-xl font-semibold mb-2">{{$course->title}}</h2>
                <p class="text-gray-600">{{$course->description}}</p>
            </div>
            
            {{-- Upcoming Events --}}
            @php
                if (Auth::user()->hasRole('faculty')){
                    $submissions = DB::select('EXEC GetUngradedSubmissionsByCourse ?', [
                        $course->courseID
                    ]);
                }
                elseif (Auth::user()->hasRole('student')){
                    $submissions = DB::select('EXEC Getpendingassignments ?,?', [
                        $course->courseID,
                        Auth::user()->id
                    ]);
                }
            @endphp
            
            <div class="col-span-1 sm:col-span-2 lg:col-span-1 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Upcoming</h2>
            
                @if (Auth::user()->hasRole('faculty'))
                    <!-- Make the content scrollable within the container -->
                    <div class="max-h-56 overflow-y-auto">
                        @forelse ($submissions as $submit)
                            <div class="mb-3 p-3 border-b border-gray-200">
                                <h3 class="text-sm font-medium text-gray-800">{{ $submit->FullName }}</h3>
                                <p class="text-gray-600 text-xs mb-1">{{ $submit->title }}</p>
                                <p class="text-gray-500 text-xs">
                                    @php
                                        $submittedAt = \Carbon\Carbon::parse($submit->submittedAt);
                                    @endphp
                                    {{ $submittedAt->diffForHumans() }} <!-- Shows time like "x minutes ago" -->
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500">No upcoming submissions</p>
                        @endforelse
                    </div>
            
                @elseif (Auth::user()->hasRole('student'))
                    <div class="max-h-56 overflow-y-auto">
                        @forelse ($submissions as $submit)
                            <div class="mb-3 p-3 border-b border-gray-200">
                                <p class="text-gray-600 text-xs mb-1">{{ $submit->title }}</p>
            
                                {{-- Instructions truncated to 30 characters --}}
                                <p class="text-gray-500 text-xs mb-1">
                                    {{ \Str::limit($submit->instructions, 30, '...') }}
                                </p>
                                {{-- Due date logic --}}
                                @php
                                $dueDate = \Carbon\Carbon::parse($submit->dueDate);
                                $now = \Carbon\Carbon::now();
                                
                                // Check if the submission is late (due date is in the past)
                                $isLate = $dueDate->isPast();
                            @endphp

                            {{-- Time left and due date --}}
                            <p class="text-gray-500 text-xs flex items-center">
                                {{-- Display red icon if submission is late --}}
                                @if ($isLate)
                                    <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                                    <span class="text-red-600">
                                        {{ $dueDate->diffForHumans($now, true) }} ago
                                    </span>
                                    <span class="text-blue-600 ml-2">
                                        ({{ $dueDate->format('l, F j, Y') }})
                                    </span>
                                @else
                                    {{-- Display time left --}}
                                    <i class="fas fa-clock text-green-500 mr-2"></i>
                                    <span class="text-green-500">
                                        {{ $dueDate->diffForHumans($now, true) }} left
                                    </span>
                                    <span class="text-blue-600 ml-2">
                                        ({{ $dueDate->format('l, F j, Y') }})
                                    </span>
                                @endif
                            </p>

                              

                        </div>
                        @empty
                            <p class="text-gray-500">No upcoming submissions</p>
                        @endforelse
                    </div>
                @endif
            </div>
            
            

            {{-- Faculty: Create Post Button --}}
            @if (Auth::user()->hasRole('faculty'))
                <div class="col-span-1 sm:col-span-2 lg:col-span-2 bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Post Something to Class</h2>
                    <p class="text-gray-600 mb-6">Create a post for the class. Engage with your peers by sharing updates, assignments, or resources.</p>
                
                    <div class="space-y-4 sm:space-y-0 sm:flex sm:justify-start sm:space-x-4">
                        <!-- Create Post Button -->
                        <button
                            class="w-full sm:w-auto bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2 rounded-md hover:from-blue-600 hover:to-blue-500 transition duration-200 ease-in-out focus:outline-none"
                            onclick="togglePopupModule(true)">
                            <i class="fas fa-pencil-alt mr-2"></i> Create Post
                        </button>
                
                        <!-- Create Assignment Button -->
                        <button
                            class="w-full sm:w-auto bg-gradient-to-r from-green-500 to-green-600 text-white px-5 py-2 rounded-md hover:from-green-600 hover:to-green-500 transition duration-200 ease-in-out focus:outline-none"
                            onclick="togglePopupModule2(true)">

                            <i class="fas fa-file-alt mr-2"></i> Create Assignment
                        </button>
                    </div>
                </div>
            @endif

            <div class="col-span-1 sm:col-span-2 lg:col-span-3 mb-6">
                <!-- Filter Form -->
                <form method="GET" action="{{ request()->url() }}" class="space-y-4">
                    <!-- Input Group -->
                    <div class="flex flex-wrap gap-4 items-center">
                        <!-- Search Input -->
                        <div class="flex-1 min-w-[200px]">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Search by title" 
                                value="{{ request('search') }}" 
                                class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300"
                            >
                        </div>
            
                        <!-- Sort Toggle -->
                        <div class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                id="sort" 
                                name="sort" 
                                value="desc" 
                                class="rounded border-gray-300 text-blue-600 focus:ring focus:ring-blue-300"
                                {{ request('sort') === 'desc' ? 'checked' : '' }}
                            >
                            <label for="sort" class="text-sm font-medium text-gray-700">Sort Descending</label>
                        </div>
            
                        <!-- Submit Button -->
                        <div>
                            <button 
                                type="submit" 
                                class="bg-blue-500 text-white p-2 px-4 rounded-lg hover:bg-blue-600 transition"
                            >
                                Apply
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Pagination Links -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                <div class="mt-4">
                    {{ $modulesPaginated->appends(request()->query())->links() }}
                </div>
            </div>
            
            <!-- Modules -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                @if($modulesPaginated->isEmpty())
                    <p class="text-gray-500 text-center">No modules available</p>
                @else
                    @foreach ($modulesPaginated as $module)
                        <x-faculty.moduleview :module="$module" :course="$course"/>
                        <br>
                    @endforeach
                @endif
            </div>
            
            
            

        </div>

        {{-- Popup Modal --}}
        <div id="modulePopup" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
            <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2 sm:w-3/4 lg:w-1/2">
                <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="togglePopupModule(false)">
                    &times;
                </button>
                {{-- Include the Laravel Blade component --}}
                <x-createmodule :course="$course"/>
            </div>
        </div>
        <div id="modulePopup2" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
            <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2 sm:w-3/4 lg:w-1/2">
                <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="togglePopupModule2(false)">
                    &times;
                </button>
                {{-- Include the Laravel Blade component --}}
                <x-faculty.insert.createassignment :course="$course"/>
            </div>
        </div>

    </div>
</div>

<script>
    function togglePopupModule(show) {
        const popup = document.getElementById('modulePopup');
        if (show) {
            popup.classList.remove('hidden');
        } else {
            popup.classList.add('hidden');
        }
    }

    function togglePopupModule2(show) {
        const popup = document.getElementById('modulePopup2');
        if (show) {
            popup.classList.remove('hidden');
        } else {
            popup.classList.add('hidden');
        }
    }

    function toggleCourseDropdown(event, courseId) {
        event.stopPropagation(); // Prevent click from propagating
        const dropdown = document.getElementById(`course-dropdown-${courseId}`);
        dropdown.classList.toggle("hidden"); // Toggle visibility
    }

    // Close dropdowns when clicking outside
    document.addEventListener("click", () => {
        document.querySelectorAll("[id^='course-dropdown-']").forEach((dropdown) => {
            if (!dropdown.classList.contains("hidden")) {
                dropdown.classList.add("hidden");
            }
        });
    });
</script>
