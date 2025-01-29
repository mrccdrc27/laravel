<div class="container mx-auto mt-5 p-6">
    <h1 class="text-3xl font-bold mb-5 text-center text-gray-800">Submissions</h1>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="lmsred text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Full Name</th>
                    <th class="py-3 px-4 text-left">Title</th>
                    <th class="py-3 px-4 text-left">Instructions</th>
                    <th class="py-3 px-4 text-left">Due Date</th>
                    <th class="py-3 px-4 text-left">Content</th>
                    <th class="py-3 px-4 text-left">Submitted At</th>
                    <th class="py-3 px-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-800">
                @foreach ($submissions as $submission)
                <tr class="hover:bg-gray-100 transition" style="min-height: 2.5rem;">
                    <td class="py-3 px-4">
                        {{ $submission->fullName }}
                    </td>
                    
                    <td class="py-3 px-4 flex items-center">
                        <i class="fas fa-book-open text-blue-500 mr-2"></i> 
                        {{ $submission->title }}
                    </td>
                    
                    <td class="py-3 px-4">
                        {{ Str::limit($submission->instructions, 50) }}
                    </td>
                    
                    <td class="py-3 px-4">
                        <i class="fas fa-calendar text-red-500 mr-2"></i> 
                        {{ \Carbon\Carbon::parse($submission->dueDate)->format('M d, Y') }}
                    </td>
                    
                    <td class="py-3 px-4">
                        {{ Str::limit($submission->content, 50) }}
                    </td>
                    
                    <td class="py-3 px-4">
                        <i class="fas fa-clock text-gray-500 mr-2"></i> 
                        {{ \Carbon\Carbon::parse($submission->submittedAt)->format('M d, Y h:i A') }}
                    </td>
                    
                    <td class="py-3 px-4">
                        @if ($submission->SubmissionStatus === 'On Time')
                            <span class="text-green-600 font-bold flex items-center">
                                <i class="fas fa-check-circle mr-2"></i> 
                                On Time
                            </span>
                        @elseif ($submission->SubmissionStatus === 'Late')
                            <span class="text-yellow-500 font-bold flex items-center">
                                <i class="fas fa-hourglass-half mr-2"></i> 
                                Late
                            </span>
                        @elseif (strtolower($submission->SubmissionStatus) === '')
                            <span class="text-red-500 font-bold flex items-center">
                                <i class="fas fa-times-circle mr-2"></i> 
                                Rejected
                            </span>
                        @else
                            <span class="text-gray-500 font-bold flex items-center">
                                <i class="fas fa-question-circle mr-2"></i> 
                                Unknown
                            </span>
                        @endif
                    </td>
                </tr>
                
               
                
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- FontAwesome for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
