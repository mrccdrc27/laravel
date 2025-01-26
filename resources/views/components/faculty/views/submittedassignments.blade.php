<div class="col-span-8 row-span-8 relative module">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300 relative">
        <!-- Settings Icon -->
        @if (Auth::user()->hasRole('student'))
        <div class="absolute top-4 right-4">
            <button
                onclick="toggleDropdown(event, {{$assignment->submissionID}})"
                class="text-gray-500 hover:text-gray-700 focus:outline-none relative"
                title="Settings"
            >
                <i class="fas fa-cog text-lg"></i> <!-- Settings icon -->
            </button>
            <!-- Dropdown Menu -->

            <div
                id="dropdown-{{$assignment->submissionID}}"
                class="settings-dropdown3 hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10"
            >
            {{-- student edit --}}

                <a
                    href="#"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                    onclick="openeditassignment({{$assignment->submissionID}})"
                >
                    Edit Submission
                </a>

                <a
                    href="#"
                    class="block px-4 py-2 text-gray-700 hover:bg-red-900 hover:text-white"
                    onclick="opendeleteassignment({{$assignment->submissionID}})"
                >
                    Delete Submission
                </a>
            </div>
        </div>
        @endif

        <p class="text-gray-500 text-sm mb-2">Created at: {{$assignment->submittedAt}}</p>
        <h3 class="text-xl font-semibold mb-4 text-gray-900">Assignment: {{$assignment->title}}</h3>

        <!-- Submission Details Section -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Submission Details</h4>

            @if (Auth::user()->hasRole('faculty'))
                <div class="text-gray-700 mb-4">
                    <strong>Submitted By:</strong> {{$assignment->firstName}} {{$assignment->middleName}} {{$assignment->lastName}}
                </div>
                <div class="text-gray-500 text-sm mb-4">
                    <strong>Email:</strong> {{$assignment->email}}
                </div>
            @endif
            
            <div class="text-gray-700 mb-4">
                <strong>Submission Content:</strong> {{$assignment->content}}
            </div>
            <div class="text-gray-500 text-sm mb-4">
                <strong>Due on:</strong> {{ \Carbon\Carbon::parse($assignment->dueDate)->format('Y-m-d, h:i A') }}
            </div>
            <div class="text-gray-500 text-sm mb-4">
                <strong>Submitted At:</strong> {{ \Carbon\Carbon::parse($assignment->submittedAt)->format('Y-m-d, h:i A') }}
            </div>
            @if ($assignment->grade)
                <div class="text-gray-700 mb-4">
                    <strong>Grade:</strong> {{$assignment->grade}}
                </div>
            @endif
            @if ($assignment->filePath)
                <div class="mb-4 flex items-center space-x-2">
                    <a href="{{ asset('storage/' . $assignment->filePath) }}" download class="inline-block">
                        <span class="border border-blue-500 bg-blue-100 text-blue-500 py-2 px-4 rounded">
                            Download Assignment
                        </span>
                    </a>
                    <p class="text-sm text-gray-500">
                        {{ str_replace(' ', '-', $assignment->title) }}.{{ pathinfo($assignment->filePath, PATHINFO_EXTENSION) }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Popup for edit assignment --}}
@if (Auth::user()->hasRole('faculty'))
    <div 
        id="assignmentcontentsubmission-{{$assignment->submissionID}}"
        class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
    >
        <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2 max-w-md">
            <button 
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
                onclick='hideitassignment({{$assignment->submissionID}})'
            >
                &times;
            </button>
            <x-faculty.update.updategrade :submit="$assignment"/>
        </div>
    </div>
@endif

@if (Auth::user()->hasRole('student'))
    <div 
        id="assignmentcontentsubmission-{{$assignment->submissionID}}"
        class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
    >
        <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2 max-w-md">
            <button 
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
                onclick='hideitassignment({{$assignment->submissionID}})'
            >
                &times;
            </button>
            <x-student.update.updatesubmission :assignment="$assignment"/>
        </div>
    </div>
@endif


{{-- Popup for delete assignment --}}
<div 
    id="assignmentdelete-{{$assignment->submissionID}}"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>
    <x-student.delete.deletesubmission :assign="$assignment"/>
</div>

<script>
    // Event listener for toggling dropdown
    document.addEventListener("click", (event) => {
        const dropdown = event.target.closest('.settings-dropdown3');
        
        if (dropdown) {
            // If clicked inside dropdown, do nothing
            return;
        }

        // Close all dropdowns when clicking outside
        document.querySelectorAll(".settings-dropdown3").forEach((dropdown) => {
            dropdown.classList.add("hidden");
        });
    });

    // Toggle visibility of the dropdown
    function toggleDropdown(event, submissionID) {
        event.stopPropagation(); // Prevent the event from bubbling
        const dropdown = document.getElementById(`dropdown-${submissionID}`);
        dropdown.classList.toggle("hidden"); // Toggle visibility
    }

    // Open the edit assignment form
    function openeditassignment(submissionID) {
        document.getElementById(`assignmentcontentsubmission-${submissionID}`).classList.remove('hidden');
    }

    // Hide the edit assignment form
    function hideitassignment(submissionID) {
        document.getElementById(`assignmentcontentsubmission-${submissionID}`).classList.add('hidden');
    }

    // Open the delete assignment form
    function opendeleteassignment(submissionID) {
        document.getElementById(`assignmentdelete-${submissionID}`).classList.remove('hidden');
    }

    // Hide the delete assignment form
    function closedeleteassignment(submissionID) {
        document.getElementById(`assignmentdelete-${submissionID}`).classList.add('hidden');
    }
</script>