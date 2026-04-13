<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Document::query()->latest()->get(),
        ]);
    }

    public function store(StoreDocumentRequest $request): JsonResponse
    {
        $document = Document::query()->create($request->validated());

        return response()->json([
            'data' => $document,
        ], 201);
    }

    public function show(Document $document): JsonResponse
    {
        return response()->json([
            'data' => $document,
        ]);
    }

    public function update(UpdateDocumentRequest $request, Document $document): JsonResponse
    {
        $document->update($request->validated());

        return response()->json([
            'data' => $document->refresh(),
        ]);
    }

    public function destroy(Document $document): JsonResponse
    {
        $document->delete();

        return response()->json(null, 204);
    }
}
