<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediaController extends Controller
{
    /**
     * Display a listing of media.
     */
    public function index(): AnonymousResourceCollection
    {
        $media = Media::with('users')
            ->when(request('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->get();

        return MediaResource::collection($media);
    }

    /**
     * Store a newly created media.
     */
    public function store(StoreMediaRequest $request): MediaResource
    {
        $media = Media::create($request->validated());

        return new MediaResource($media);
    }

    /**
     * Display the specified media.
     */
    public function show(string $id): MediaResource
    {
        $media = Media::with('users')->findOrFail($id);

        return new MediaResource($media);
    }

    /**
     * Update the specified media.
     */
    public function update(
        UpdateMediaRequest $request,
        string $id
    ): MediaResource {
        $media = Media::findOrFail($id);

        $media->update($request->validated());

        return new MediaResource($media);
    }

    /**
     * Remove the specified media.
     */
    public function destroy(string $id): JsonResponse
    {
        $media = Media::findOrFail($id);

        $media->delete();

        return response()->json([
            'message' => 'Media berhasil dihapus.',
        ], 200);
    }
}
