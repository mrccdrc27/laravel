<h2 class="text-xl font-semibold text-gray-800 mb-4">Grade Submission</h2>

<!-- Submitter Info -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Submitter Name</label>
    <p class="mt-1 text-gray-900">{{ $submit->firstName }} {{ $submit->middleName ?? '' }} {{ $submit->lastName }}</p>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Submitted At</label>
    <p class="mt-1 text-gray-900">{{ $submit->submittedAt }}</p>
</div>

<!-- Late or On Time -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Submission Status</label>
    <p class="mt-1 text-gray-900">
        {{-- Compare the current date and submitted date --}}
        @php
            $currentTime = now();
            $submittedTime = \Carbon\Carbon::parse($submit->dueDate);
            $status = $submittedTime->isAfter($submit->submittedAt) ? 'Late' : 'On Time';
        @endphp
        <span class="{{ $status == 'Late' ? 'text-red-600' : 'text-green-600' }}">{{ $status }}</span>
    </p>
</div>

<!-- Grade Input -->
<form id="gradeForm-{{ $submit->submissionID }}" method="POST" action="#">
    <div class="mb-4">
        <label for="grade-{{ $submit->submissionID }}" class="block text-sm font-medium text-gray-700">Grade</label>
        <input 
            type="number" 
            name="grade" 
            id="grade-{{ $submit->submissionID }}" 
            placeholder="Enter grade (1-100)" 
            min="1" max="100" step="1"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            required
            maxlength="3"
        >
    </div>

    <!-- Submit Button -->
    <button type="submit" 
        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
        Update Grade
    </button>
</form>

<script>
    document.getElementById("gradeForm-{{ $submit->submissionID }}").addEventListener("submit", function(event) {
        const gradeInput = document.getElementById("grade-{{ $submit->submissionID }}");
        const gradeValue = parseInt(gradeInput.value, 10);
        
        if (gradeValue < 1 || gradeValue > 100) {
            event.preventDefault(); // Prevent form submission
            alert("Please enter a grade between 1 and 100.");
        }
    });

    document.getElementById("grade-{{ $submit->submissionID }}").addEventListener("input", function(event) {
        const input = event.target;
        if (input.value.length > 3) {
            input.value = input.value.slice(0, 3); // Limit to 3 digits
        }
    });
</script>
