<div class="col-span-8 row-span-8 p-4 relative module">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300 relative">
        <!-- Settings Icon -->
        @if (Auth::user()->hasRole('faculty'))
        <div class="absolute top-4 right-4">
            <button
                onclick="toggleDropdown(event, {{$module->moduleID}})"
                class="text-gray-500 hover:text-gray-700 focus:outline-none relative"
                title="Settings"
            >
                <i class="fas fa-cog text-lg"></i> <!-- Settings icon -->
            </button>
            <!-- Dropdown Menu -->
            <div
                id="dropdown-{{$module->moduleID}}"
                class="settings-dropdown hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10"
            >
                <a
                    href="#"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2"
                    onclick="openeditmodule({{$module->moduleID}})"
                >
                    <i class="fas fa-edit text-blue-500"></i> Edit Module
                </a>
                <a
                    href="#"
                    class="block px-4 py-2 text-gray-700 hover:bg-red-100 hover:text-red-700 flex items-center gap-2"
                    onclick="opendeletemodule({{$module->moduleID}})"
                >
                    <i class="fas fa-trash text-red-500"></i> Delete Module
                </a>
            </div>
        </div>
        @endif

        <!-- Module Information -->
        <p class="text-gray-500 text-sm flex items-center gap-2 mb-2">
            <i class="fas fa-calendar-alt text-blue-500"></i> Created at: {{$module->createdAt}}
        </p>
        <h3 class="text-2xl font-semibold mb-4 text-gray-900 flex items-center gap-2">
            <i class="fas fa-book text-blue-500"></i> {{$module->title}}
        </h3>
        <p class="text-gray-700 mb-6">{{$module->content}}</p>

        <!-- File Download -->
        @if ($module->filepath)
            <div class="mb-4">
                <a href="{{ asset('storage/' . $module->filepath) }}" 
                   download 
                   class="flex items-center gap-2 border border-blue-500 bg-blue-100 text-blue-500 py-2 px-4 rounded hover:bg-blue-200 transition">
                    <i class="fas fa-download"></i> Download Module
                </a>
                <p class="text-sm text-gray-500 mt-1">
                    {{ str_replace(' ', '-', $module->title) }}.{{ pathinfo($module->filepath, PATHINFO_EXTENSION) }}
                </p>            
            </div>
        @endif
    </div>
</div>

<!-- Popup for Edit Module -->
<div 
    id="modulecontent-{{$module->moduleID}}"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>
    <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2">
        <button 
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
            onclick='hideitmodule({{$module->moduleID}})'
        >
            <i class="fas fa-times"></i>
        </button>
        <x-faculty.update.updatemodule :module="$module" :course="$course"/>
    </div>
</div>

<!-- Popup for Delete Module -->
<div 
    id="moduledelete-{{$module->moduleID}}"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>
    <x-faculty.delete.deletemodule :module="$module"/>
</div>


<script>
    function toggleDropdown(event, moduleID) {
        event.stopPropagation(); // Prevent the event from bubbling
        const dropdown = document.getElementById(`dropdown-${moduleID}`); // Identify the specific dropdown
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

    function openeditmodule(moduleID) {
        document.getElementById(`modulecontent-${moduleID}`).classList.remove('hidden');
    }

    function hideitmodule(moduleID) {
        document.getElementById(`modulecontent-${moduleID}`).classList.add('hidden');
    }


    function opendeletemodule(moduleID) {
        document.getElementById(`moduledelete-${moduleID}`).classList.remove('hidden');
    }

    function closedeletemodule(moduleID) {
        document.getElementById(`moduledelete-${moduleID}`).classList.add('hidden');
    }
</script>
