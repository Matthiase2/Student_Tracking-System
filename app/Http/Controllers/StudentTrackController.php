<?php

namespace App\Http\Controllers;

use App\Models\StudentTrack;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tracks = StudentTrack::all();
        return view('student_tracks.index', compact('tracks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student_tracks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        StudentTrack::create($request->all());

        return redirect()->route('student_tracks.index')->with('success', 'Track created successfully.');
    }

    // Other methods (show, edit, update, destroy) can be added here as needed
}