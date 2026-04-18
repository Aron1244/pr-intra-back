<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display all announcements
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json(
            Announcement::query()
                ->with(['creator', 'department'])
                ->when(
                    ! $user->canPostAnnouncements(),
                    fn ($query) => $query->where('department_id', $user->department_id)
                )
                ->latest()
                ->get()
        );
    }

    /**
     * Store new announcement
     */
    public function store(StoreAnnouncementRequest $request): JsonResponse
    {
        $announcement = Announcement::query()->create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return response()->json($announcement->load(['creator', 'department']), 201);
    }

    /**
     * Show single announcement
     */
    public function show(Announcement $announcement): JsonResponse
    {
        $this->authorize('view', $announcement);

        return response()->json($announcement->load(['creator', 'department', 'comments.user']));
    }

    /**
     * Update announcement
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement): JsonResponse
    {
        $announcement->update($request->validated());

        return response()->json($announcement->refresh()->load(['creator', 'department']), 200);
    }

    /**
     * Delete announcement
     */
    public function destroy(Announcement $announcement): JsonResponse
    {
        $this->authorize('delete', $announcement);

        $announcement->delete();

        return response()->json(null, 204);
    }
}
