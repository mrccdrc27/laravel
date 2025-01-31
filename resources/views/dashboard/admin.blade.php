<?php
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
?>
@php
    $assignments = DB::select('EXEC GetAssignmentStatusForStudent ?', [auth()->user()->id]);
    $announcements = DB::select('EXEC GetActiveAnnouncements');
    $statistics = DB::select('EXEC GetLMSStatistics');
    $perPage = 1;
    $currentPage = request()->input('page', 1); // Default to page 1 if not provided
    $offset = ($currentPage - 1) * $perPage;

    // Paginate manually
    $totalAnnouncements = count($announcements); // Get the total count of announcements
    $paginatedAnnouncements = array_slice($announcements, $offset, $perPage); // Slice the announcements array for pagination

    // Create a paginator instance manually
    $announcementsPaginator = new LengthAwarePaginator(
        $paginatedAnnouncements, // Data for current page
        $totalAnnouncements,     // Total number of announcements
        $perPage,               // Items per page
        $currentPage,           // Current page
        ['path' => request()->url(), 'query' => request()->query()] // Keep current query parameters in pagination links
    );
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 dark:text-blue-400 leading-tight">
            {{ __('Admin dashboard') }}
        </h2>        
    </x-slot>

<div>
  <div class="container mx-auto p-8 space-y-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">University Announcements</h2>
        <div class="mt-4">
            {{ $announcementsPaginator->links() }}
        </div>
        <ul class="space-y-4">
            @foreach($announcementsPaginator as $announcement)
                <li class="flex items-start space-x-6 bg-white">
                    <!-- Image Section -->
                    <div class="w-1/3 h-48 rounded-lg flex-shrink-0 overflow-hidden">
                        {{-- Determine the SVG based on the last digit of the announcement's ID --}}
                        @php
                            $imageIndex = $announcement->id % 10; // Get the last digit of the ID
                        @endphp
                        <img src="{{ asset('images/' . $imageIndex . '.svg') }}" alt="Announcement Image" class="w-full h-full object-contain"/>
                    </div>

                    <!-- Text Section -->
                    <div class="w-2/3 flex flex-col justify-between">
                        <p class="font-semibold text-xl text-gray-800">{{ $announcement->title }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $announcement->body }}</p>
                        <span class="text-xs text-gray-400 mt-2">{{ \Carbon\Carbon::parse($announcement->date_posted)->diffForHumans() }}</span>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>


    <!-- 1st Row: University Announcements -->


    <!-- 2nd Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- 2nd Row, 1st Column: Submissions Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="container mx-auto px-4 py-8 bg-cover bg-center" style="background-image: url('{{ asset('images/card .svg') }}');">
                <h1 class="text-4xl font-extrabold text-white mb-8 text-center">LMS Statistics</h1>
        
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Total Enrollments -->
                    <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h2 class="text-xl font-semibold text-gray-800">Total Enrollments</h2>
                        <p class="text-3xl font-bold text-gray-900 mt-4">{{ $statistics[0]->total_enrollments }}</p>
                    </div>
        
                    <!-- Total Students -->
                    <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h2 class="text-xl font-semibold text-gray-800">Total Students</h2>
                        <p class="text-3xl font-bold text-gray-900 mt-4">{{ $statistics[0]->total_students }}</p>
                    </div>
        
                    <!-- Total Modules -->
                    <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h2 class="text-xl font-semibold text-gray-800">Total Modules</h2>
                        <p class="text-3xl font-bold text-gray-900 mt-4">{{ $statistics[0]->total_modules }}</p>
                    </div>
        
                    <!-- Total Users (excluding admins) -->
                    <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h2 class="text-xl font-semibold text-gray-800">Total Users</h2>
                        <p class="text-3xl font-bold text-gray-900 mt-4">{{ $statistics[0]->total_users }}</p>
                    </div>
        
                    <!-- Total Faculty -->
                    <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h2 class="text-xl font-semibold text-gray-800">Total Faculty</h2>
                        <p class="text-3xl font-bold text-gray-900 mt-4">{{ $statistics[0]->total_faculty }}</p>
                    </div>
        
                    <!-- Total Courses -->
                    <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h2 class="text-xl font-semibold text-gray-800">Total Courses</h2>
                        <p class="text-3xl font-bold text-gray-900 mt-4">{{ $statistics[0]->total_course }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2nd Row, 2nd Column: Calendar View -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            
          <div id="tooltip" class="tooltip"></div>
          <div id="calendar"></div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            events: [
                @foreach($announcements as $announcement)
                { 
                    title : '{{ $announcement->title }}',
                    start : '{{ $announcement->date_posted }}',
                    color : 'lmsred',
                    description: '{{ $announcement->body }}'
                },
                @endforeach
            ],
            eventRender: function(event, element) {
                element.on('mouseover', function(e) {
                    $('#tooltip').html(event.description).css({
                        display: 'block',
                        top: e.pageY + 10,
                        left: e.pageX + 10
                    });
                }).on('mousemove', function(e) {
                    $('#tooltip').css({
                        top: e.pageY + 10,
                        left: e.pageX + 10
                    });
                }).on('mouseout', function() {
                    $('#tooltip').css('display', 'none');
                });
            }
        });
    });
</script>
</x-app-layout>
