<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sections = Section::all();

        // Adjust field names if needed
        $attendanceRecords = Attendance::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'section', 'status', 'created_at']); // Explicitly select 'id'

        return view('dashboard', compact('user', 'sections', 'attendanceRecords'));
    }
}