<div class="col-span-8 row-span-8 p-4 relative module">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300 relative">
        <!-- Settings Icon -->
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
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                    onclick="openeditmodule({{$module->moduleID}})"
                >
                    Edit Module
                </a>
                <a
                    href="#"
                    class="block px-4 py-2 text-gray-700 hover:bg-red-900 hover:text-white"
                    onclick="opendeletemodule({{$module->moduleID}})"
                >
                    Delete Module
                </a>
            </div>
        </div>

        <p class="text-gray-500 text-sm">Created at: {{$module->createdAt}}</p>
        <h3 class="text-xl font-semibold mb-4 text-gray-900">{{$module->title}}</h3>
        <p class="text-gray-700 mb-6">{{$module->content}}</p>
        
        @if ($module->filepath)
            <div class="mb-4">
                <a href="{{ asset('storage/' . $module->filepath) }}" 
                   download 
                   class="">
                    <span class="border border-blue-500 bg-blue-100 text-blue-500 py-2 px-4 rounded">
                        Download Module <!-- Display the extracted file name -->
                    </span>
                </a>

                <p class="text-sm text-gray-500">
                    {{ str_replace(' ', '-', $module->title) }}.{{ pathinfo($module->filepath, PATHINFO_EXTENSION) }}
                </p>            
            </div>
        @endif
    </div>
</div>
{{-- Popup for edit module --}}
<div 
    id="modulecontent-{{$module->moduleID}}"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>
    <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2">
        <button 
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
            onclick='hideitmodule({{$module->moduleID}})'
        >
            &times;
        </button>
        {{-- Include the Laravel Blade component --}}
        <x-faculty.update.updatemodule :module="$module" :course="$course"/>
    </div>
</div>

{{-- Popup for delete module --}}
<div 
    id="moduledelete-{{$module->moduleID}}"
    class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
>           <x-faculty.delete.deletemodule :module="$module"/>
    {{-- <div class="relative bg-white p-6 rounded-lg shadow-lg w-1/2">
        <button 
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
            onclick='closedeletemodule({{$module->moduleID}})'
        >
            &times;
        </button>

    </div> --}}
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
