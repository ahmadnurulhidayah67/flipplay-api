<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCollectionRequest;
use App\Http\Resources\MediaResource;
use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // GET /api/users
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::withCount('media')->paginate(10));
    }

    // GET /api/users/{user} -> pengguna beserta koleksinya
    public function show(User $user): UserResource
    {
        return new UserResource($user->load('media'));
    }

    // GET /api/users/{user}/collection -> koleksi media milik pengguna
    public function collection(User $user): AnonymousResourceCollection
    {
        return MediaResource::collection($user->media()->orderBy('title')->paginate(10));
    }

    // POST /api/users/{user}/collection  body: {"media_id": 1}
    // Pola "cek -> ubah" dibungkus transaction + lockForUpdate agar aman dari race condition
    public function addToCollection(AddToCollectionRequest $request, User $user): JsonResponse
    {
        return DB::transaction(function () use ($request, $user) {
            User::whereKey($user->id)->lockForUpdate()->firstOrFail();

            $mediaId = $request->validated('media_id');

            if ($user->media()->wherePivot('media_id', $mediaId)->exists()) {
                return response()->json(['message' => 'Media sudah ada di koleksi'], 409);
            }

            $user->media()->attach($mediaId);

            return response()->json([
                'message' => 'Media berhasil ditambahkan ke koleksi',
                'data'    => (new MediaResource(Media::findOrFail($mediaId)))->resolve(),
            ], 201);
        });
    }

    // DELETE /api/users/{user}/collection/{media}
    public function removeFromCollection(User $user, Media $media): JsonResponse
    {
        if ($user->media()->detach($media->id) === 0) {
            return response()->json(['message' => 'Media tidak ada di koleksi'], 404);
        }

        return response()->json(['message' => 'Media berhasil dihapus dari koleksi']);
    }
}
