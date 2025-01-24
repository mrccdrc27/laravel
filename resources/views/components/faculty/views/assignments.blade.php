<div class="col-span-8 row-span-8 p-6 relative module">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300 relative">
        <!-- Settings Icon -->
        <div class="absolute top-4 right-4">
            <button
                onclick="toggleDropdown(event, {{$assignment->assignmentID}})"
                class="text-gray-500 hover:text-gray-700 focus:outline-none relative"
                title="Settings"
            >
                <i class="fas fa-cog text-lg"></i> <!-- Settings icon -->
            </button>
            <!-- Dropdown Menu -->
            <div
                id="dropdown-{{$assignment->assignmentID}}"
                class="settings-dropdown hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10"
            >
                <a
                    href="#"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                    onclick="openeditassignment({{$assignment->assignmentID}})"
                >
                    Edit Assignment
                </a>
                <a
                    href="#"
                    class="block px-4 py-2 text-gray-700 hover:bg-red-900 hover:text-white"
                    onclick="opendeleteassignment({{$assignment->assignmentID}})"
                >
                    Delete Assignment
                </a>
            </div>
        </div>

        <p class="text-gray-500 text-sm mb-2">Created at: {{$assignment->createdAt}}</p>
        <h3 class="text-xl font-semibold mb-4 text-gray-900">{{$assignment->title}}</h3>
        <p class="text-gray-700 mb-4">{{$assignment->instructions}}</p>
        <p class="text-gray-500 text-sm mb-4">Due Date: {{$assignment->dueDate}}</p>
        
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

{{-- Popup for edit assignment --}}
<div 
    id="assignmentcontent-{{$assignment->assignmentID}}"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>
    <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2 max-w-md">
        <button 
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
            onclick='hideitassignment({{$assignment->assignmentID}})'
        >
            &times;
        </button>
        {{-- Include the Laravel Blade component --}}
        {{-- <x-faculty.update.updateassignment :assignment="$assignment" :course="$course"/> --}}
    </div>
</div>

{{-- Popup for delete assignment --}}
<div 
    id="assignmentdelete-{{$assignment->assignmentID}}"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>           
    {{-- <x-faculty.delete.deleteassignment :assignment="$assignment"/> --}}
</div>

<script>
    function toggleDropdown(event, assignmentID) {
        event.stopPropagation(); // Prevent the event from bubbling
        const dropdown = document.getElementById(`dropdown-${assignmentID}`); // Identify the specific dropdown
        dropdown.classList.toggle("hidden"); // Toggle visibility
    }

    // Close all dropdowns when clicking outside
    document.addEventListener("click", () => {
        document.querySelectorAll(".settings-dropdown").forEach((dropdown) => {
            if (!dropdown.classList.contains("hidden")) {
                dropdown.classList.add("hidden");
            }
        });
    });

    function openeditassignment(assignmentID) {
        document.getElementById(`assignmentcontent-${assignmentID}`).classList.remove('hidden');
    }

    function hideitassignment(assignmentID) {
        document.getElementById(`assignmentcontent-${assignmentID}`).classList.add('hidden');
    }

    function opendeleteassignment(assignmentID) {
        document.getElementById(`assignmentdelete-${assignmentID}`).classList.remove('hidden');
    }

    function closedeleteassignment(assignmentID) {
        document.getElementById(`assignmentdelete-${assignmentID}`).classList.add('hidden');
    }
</script>
