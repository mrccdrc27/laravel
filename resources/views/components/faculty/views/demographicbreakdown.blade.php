@php
  $userID = Auth::user()->id;
  $enrollments = DB::select('EXEC GetEnrollmentStatsForFaculty @facultyID = ?', [$userID]);
@endphp

<div class="container mx-auto p-6 bg-gray-100 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-gray-700 mb-6 text-center">Enrollment Statistics for Faculty</h1>
    
    <div class="flex justify-end mb-4">
            <a href="{{ route('download.pdf') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all">
                Download PDF
            </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="py-3 px-6 border">Course Title</th>
                    <th class="py-3 px-6 border">Male</th>
                    <th class="py-3 px-6 border">Female</th>
                    <th class="py-3 px-6 border">Total Enrollment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enrollments as $enrollment)
                    <tr class="border-b hover:bg-gray-100 transition-all">
                        <td class="py-3 px-6 border">{{ $enrollment->title }}</td>
                        <td class="py-3 px-6 border text-center">{{ $enrollment->male }}</td>
                        <td class="py-3 px-6 border text-center">{{ $enrollment->female }}</td>
                        <td class="py-3 px-6 border text-center font-semibold">{{ $enrollment->totalEnrollment }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
