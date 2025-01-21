<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 dark:text-blue-400 leading-tight">
            {{ __('faculty dashboard') }}
        </h2>        
    </x-slot>
<<<<<<< HEAD

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            </div>
        </div>
    </div>

=======
      <!-- Main Content -->
  <div class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Welcome Section -->
      <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800">Welcome back, [User Name]!</h2>
        <p class="mt-2 text-gray-600">Here’s what’s happening with your learning progress:</p>
        <div class="mt-4">
          <p class="text-gray-700">Courses Completed: <strong>3</strong></p>
          <p class="text-gray-700">Active Courses: <strong>2</strong></p>
          <p class="text-gray-700">Upcoming Deadlines: <strong>1</strong></p>
        </div>
      </div>

      <!-- Notifications -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800">Notifications</h2>
        <ul class="mt-4 text-gray-600 space-y-2">
          <li>- Complete "Math 101" assignment by Jan 23.</li>
          <li>- New course "Physics Basics" added to your dashboard.</li>
          <li>- Reminder: Weekly meeting tomorrow at 3 PM.</li>
        </ul>
      </div>
    </div>

    <!-- Course Cards -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-10">Your Courses</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
      <!-- Example Course Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-800">Math 101</h3>
        <p class="text-gray-600 mt-2">Progress: 60%</p>
        <div class="mt-4">
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Resume Course
          </button>
        </div>
      </div>

      <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-800">Physics Basics</h3>
        <p class="text-gray-600 mt-2">Progress: 20%</p>
        <div class="mt-4">
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Start Course
          </button>
        </div>
      </div>

      <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-800">History 201</h3>
        <p class="text-gray-600 mt-2">Progress: 80%</p>
        <div class="mt-4">
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Resume Course
          </button>
        </div>
      </div>
    </div>
  </div>


>>>>>>> b0216354796e7af736c3223e4bce440a571e8527

</x-app-layout>
