<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubjectQualification; // Make sure this matches your model name!

class QualificationController extends Controller
{
    /**
     * Store a newly created teaching qualification request.
     */
    public function store(Request $request)
    {
        // 1. The Strict Validation Rules
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'proof_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // max 2MB
        ]);

        // 2. Save the File Safely
        $path = $request->file('proof_document')->store('qualifications', 'public');

        // 3. Save to the Database
        UserSubjectQualification::create([
            'user_id' => auth()->id(),
            'subject_name' => $validated['subject'],
            'proof_file_path' => $path,
            'status' => 'pending',
        ]);

        // 4. Return with a success toast!
        // Adjust this redirect to wherever you want the user to go after submitting
        return back()->with('success', 'Application submitted! An admin will review your proof shortly.');
    }
}