<div class="flex justify-center">
    <div class="container col-span-8">
        <x-success-message/>
        {{-- Course Information Cards --}}
        <div class="grid grid-cols-8 gap-6 w-full p-6">
            <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                <x-faculty.coursenavbar :course="$course"/>
            </div>         
            {{-- Content goes here --}}
            <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                <x-faculty.update.updatecourse/>
            </div>       
            <div class="col-span-8 bg-white p-6 rounded-lg shadow-md relative">
                <x-faculty.delete.deletecourseinit :course="$course"/>
            </div>       

        </div>
    </div>
</div>
