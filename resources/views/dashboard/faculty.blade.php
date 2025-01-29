<php?
use Illuminate\Http\Request;
?>

@php
      $assignments = DB::select('EXEC GetAssignmentStatusForStudent ?', [auth()->user()->id]);
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
        {{ __('faculty dashboard') }}
    </h2>        
</x-slot>

<div>
  <div class="container mx-auto p-8 space-y-8">

    <!-- 1st Row: University Announcements -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">University Announcements</h2>
        <ul class="space-y-4">
            <li class="text-gray-700">
                <p class="font-semibold">Semester Break Dates Updated</p>
                <p class="text-sm text-gray-500">The university has revised the semester break dates. Please take note of the new schedule.</p>
                <span class="text-sm text-gray-400">1 hour ago</span>
            </li>
            <li class="text-gray-700">
                <p class="font-semibold">New Policy for Online Exams</p>
                <p class="text-sm text-gray-500">All online exams will now require ID verification. Read the full guidelines on the website.</p>
                <span class="text-sm text-gray-400">2 days ago</span>
            </li>
            <li class="text-gray-700">
                <p class="font-semibold">Guest Lecture on AI</p>
                <p class="text-sm text-gray-500">Don't miss the guest lecture by Dr. Smith on Artificial Intelligence next Friday.</p>
                <span class="text-sm text-gray-400">3 days ago</span>
            </li>
        </ul>
    </div>

    <!-- 2nd Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- 2nd Row, 1st Column: Submissions Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">Recent Submissions</h2>
            <ul class="space-y-4">
                <li class="flex justify-between text-gray-700">
                    <span>Math 101 - Assignment 1</span>
                    <span class="text-green-600">Submitted: 2 hours ago</span>
                </li>
                <li class="flex justify-between text-gray-700">
                    <span>History 202 - Essay</span>
                    <span class="text-yellow-600">Submitted: 1 day ago</span>
                </li>
                <li class="flex justify-between text-gray-700">
                    <span>Physics 303 - Lab Report</span>
                    <span class="text-red-600">Late: 3 days ago</span>
                </li>
            </ul>
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
