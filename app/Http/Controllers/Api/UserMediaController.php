<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserMediaController extends Controller
{
    /**
     * Display the user's media collection.
     */
    public function index(User $user): AnonymousResourceCollection
    {
        $media = $user->media()->with('users')->get();

        return MediaResource::collection($media);
    }

    /**
     * Add media to the user's collection.
     */
    public function store(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'media_id' => 'required|exists:media,id',
        ]);

        if ($user->media()->where('media.id', $validated['media_id'])->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi pengguna.',
            ], 422);
        }

        $user->media()->attach($validated['media_id']);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi.',
        ], 201);
    }

    /**
     * Remove media from the user's collection.
     */
    public function destroy(User $user, Media $media): JsonResponse
    {
        $detached = $user->media()->detach($media->id);

        if ($detached === 0) {
            return response()->json([
                'message' => 'Media tidak ditemukan dalam koleksi pengguna.',
            ], 404);
        }

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi.',
        ], 200);
    }
}
