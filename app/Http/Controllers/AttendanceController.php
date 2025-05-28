<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class AttendanceController extends Controller
{

    
    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id', // Validates that a valid section_id is passed
        ]);

        $section = \App\Models\Section::find($request->section_id); // Fetch the section model

        if (!$section) {
            return redirect()->back()->with('error', 'Selected section not found.');
        }

        Attendance::create([
            'user_id' => Auth::id(),
            'section' => $section->name, // Store the section's name (assuming 'name' attribute on Section model)
            'timestamp' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Attendance taken successfully!');
    }

    /**
     * Remove the specified attendance record from storage.
     */
    public function destroy(Attendance $attendance)
    {
        // Ensure the authenticated user owns this attendance record
        if ($attendance->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this attendance record.');
        }

        $attendance->delete();

        return redirect()->route('dashboard')->with('success', 'Attendance record deleted successfully!');
    }
}
