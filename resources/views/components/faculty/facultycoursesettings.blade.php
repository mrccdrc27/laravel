<div class="flex justify-center">
    <div class="container max-w-7xl px-4 sm:px-6 lg:px-8 col-span-8">
        <x-success-message/>
        {{-- Course Information Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full p-6 container">
            <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                <x-faculty.coursenavbar :course="$course"/>
            </div>         
            
            {{-- Content goes here --}}
            @if (Auth::user()->hasRole('faculty'))
                <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                    <x-faculty.update.updatecourse :course="$course"/>
                </div>       
                <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                    <x-faculty.delete.deletecourseinit :course="$course" />
                </div>       
            @endif

            @if (Auth::user()->hasRole('student'))
                <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                    <x-faculty.delete.deletecourseinit :course="$course" :enrollment="$enrollment" />
                </div>       
            @endif

        </div>
    </div>
</div>
