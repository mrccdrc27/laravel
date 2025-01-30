<?php
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
?>
@php
    $assignments = DB::select('EXEC GetAssignmentStatusForStudent ?', [auth()->user()->id]);
    $submissions = DB::select('EXEC GetPendingAssignmentsStudent ?',[auth()->user()->id]);
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
          {{ __('Student dashboard') }}
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
          <div class="max-w-4xl mx-auto p-4">
              <!-- Header with Total Submissions Count -->
              <h2 class="text-3xl font-semibold text-gray-800 mb-4">Recent Submissions</h2>
              {{-- <p class="text-sm text-gray-600 mb-4">Total submissions: {{ count($submissions) }}</p> --}}
          
              <!-- Scrollable container for the list -->
              <div class="max-h-96 overflow-y-auto">
                  <ul class="space-y-4">
                      @foreach ($submissions as $submission)
                          <li class="flex justify-between items-center p-4 border rounded-lg 
                                      {{ $submission->SubmissionStatus == 'Pending' ? 'text-gray-500' : '' }}
                                      {{ $submission->SubmissionStatus == 'Past Due' ? 'text-red-600' : '' }}">
              
                              <div class="flex flex-col">
                                  <!-- Course TItle -->
                                  <span class="font-semibold text-lg">{{ $submission->CourseTitle }}</span>

                                  <!-- Assignment Title -->
                                  <span class="text-sm text-gray-600">{{ $submission->AssignmentTitle }}</span>
                              </div>
              
                              <div class="flex flex-col items-end">
                                  <!-- Submitted At (formatted as relative time) -->
                                  <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($submission->dueDate)->diffForHumans() }}</span>
              
                                  <!-- Submission Status -->
                                  <span class="text-sm font-bold 
                                      {{ $submission->SubmissionStatus == 'Pending' ? 'text-gray-500' : '' }}
                                      {{ $submission->SubmissionStatus == 'Past Due' ? 'text-red-600' : '' }}">
                                      {{ $submission->SubmissionStatus }}
                                  </span>
                              </div>
                          </li>
                      @endforeach
                  </ul>
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

</div>

<div class="bg-white p-6 rounded-lg shadow-lg">
<div id="tooltip">
</div>

<div id="calendar"></div>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script>
  $(document).ready(function() {
      $('#calendar').fullCalendar({
          events: [
              @foreach($assignments as $assignment)
              { 
                  // title : '{{ $assignment->title }} - {{ $assignment->assignment_status }}',
                  start : '{{ $assignment->dueDate }}',
                  color : '{{ $assignment->assignment_status == "Submitted" ? "green" : "red" }}',
                  description: 'Assignment: {{ $assignment->title }}<br>Status: {{ $assignment->assignment_status }}<br>Due Date: {{ $assignment->dueDate }}'
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
