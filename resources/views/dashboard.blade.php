<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 md:p-8">
                
                <!-- Header Title -->
                <h1 class="text-3xl font-bold text-center text-purple-600 dark:text-purple-400 mb-8">
                    Student Dashboard
                </h1>

                <!-- Student Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 items-center">
                    <div class="flex flex-col items-center md:items-start col-span-1">
                        <div class="bg-purple-500 dark:bg-purple-700 rounded-full p-4 mb-2">
                            <!-- Placeholder for user icon -->
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">Student Information</h2>
                    </div>
                    <div class="col-span-1 md:col-span-2 text-gray-700 dark:text-gray-300 space-y-1">
                        <p><strong>Student ID:</strong> {{ Auth::user()->studentid ?? 'N/A' }}</p>
                        <p><strong>First Name:</strong> {{ Auth::user()->first_name ?? 'N/A' }}</p>
                        <p><strong>Last Name:</strong> {{ Auth::user()->last_name ?? 'N/A' }}</p>
                        <p><strong>Year Level:</strong> {{ Auth::user()->year_level ?? 'N/A' }}</p>
                        <p><strong>Course:</strong> {{ Auth::user()->course ?? 'N/A' }}</p>
                        <p><strong>School Attended:</strong> {{ Auth::user()->school ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Section/Dept Time Stamp Schedule Banner -->
                <div class="bg-yellow-300 dark:bg-yellow-500 text-yellow-800 dark:text-yellow-100 p-4 rounded-md text-center mb-8 font-semibold">
                    Section/Dept Time Stamp Schedule
                </div>

                <!-- Actions Section -->
                <form method="POST" action="{{ route('attendance.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center mb-6">
                    @csrf
                    <div class="col-span-1">
                        <label for="section_id" class="sr-only">Select Section</label>
                        <select name="section_id" id="section_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                            @if($sections->isEmpty())
                                <option disabled>No sections available</option>
                            @else
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name ?? 'Unnamed Section' }}</option> <!-- Assuming section has a 'name' attribute -->
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-1">
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                            Take Attendance
                        </button>
                    </div>
                </form>
                <!-- The Edit Profile and Logout buttons are outside the attendance form -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center mb-6">
                    <div class="col-span-1 md:col-start-3"> <!-- Adjust column start for layout -->
                        <!-- Link to profile edit page -->
                        <a href="{{ route('profile.edit') }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                            Edit Profile
                        </a>
                    </div>
                    <div class="col-span-1 md:col-span-1">
                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Attendance Status & Delete -->
                @php
                    $latestAttendance = $attendanceRecords->first();
                @endphp

                @if ($latestAttendance)
                    <div class="mt-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                        <p class="mb-2 md:mb-0">
                            Attendance taken for {{ $latestAttendance->section ?? 'N/A Section' }} at {{ $latestAttendance->created_at->format('n/j/Y, g:i:s A') }}
                            {{-- If you have a 'status' field you want to display: Status: {{ $latestAttendance->status }} --}}
                        </p>
                        <form method="POST" action="{{ route('attendance.destroy', ['attendance' => $latestAttendance->id]) }}" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                                Delete Attendance
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-6 text-sm text-gray-600 dark:text-gray-400">
                        <p>No attendance records found for the latest entry.</p>
                    </div>
                @endif

                <!-- Attendance History -->
                <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Attendance History</h3>
                    @if ($attendanceRecords->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Section
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Date & Time
                                        </th>
                                        <!-- Add other columns if needed, e.g., Status -->
                                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($attendanceRecords as $record)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $record->section ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $record->created_at->format('n/j/Y, g:i:s A') }}
                                            </td>
                                            <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $record->status ?? 'N/A' }}
                                            </td> -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-600 dark:text-gray-400">No attendance history found.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
