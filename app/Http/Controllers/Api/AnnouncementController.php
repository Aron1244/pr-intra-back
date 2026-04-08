<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display all announcements
     */
    public function index()
    {
        return response()->json(
            Announcement::latest()->get()
        );
    }

    /**
     * Store new announcement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement = Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'created_by' => auth()->id(), // important
        ]);

        return response()->json(
            $announcement,
            201
        );
    }

    /**
     * Show single announcement
     */
    public function show(Announcement $announcement)
    {
        return response()->json($announcement);
    }

    /**
     * Update announcement
     */
    public function update(
        Request $request,
        Announcement $announcement
    ) {

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        $announcement->update($validated);

        return response()->json(
            $announcement,
            200
        );
    }

    /**
     * Delete announcement
     */
    public function destroy(
        Announcement $announcement
    ) {

        $announcement->delete();

        return response()->json(
            null,
            204
        );
    }
}