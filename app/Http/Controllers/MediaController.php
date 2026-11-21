<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediaController extends Controller
{
    // GET /api/media?title=attack&type=Anime  -> daftar + pencarian judul
    public function index(Request $request): AnonymousResourceCollection
    {
        $media = Media::with('users')
            ->search($request->query('title'))
            ->when($request->query('type'), fn ($q, $type) => $q->where('type', $type))
            ->orderBy('title')
            ->paginate(10);

        return MediaResource::collection($media);
    }

    // POST /api/media -> tambah media (201)
    public function store(StoreMediaRequest $request): JsonResponse
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))->response()->setStatusCode(201);
    }

    // GET /api/media/{media} -> detail + pengguna yang memasukkan ke koleksi (404 otomatis)
    public function show(Media $media): MediaResource
    {
        return new MediaResource($media->load('users'));
    }

    // PATCH /api/media/{media}
    public function update(StoreMediaRequest $request, Media $media): MediaResource
    {
        $media->update($request->validated());

        return new MediaResource($media);
    }

    // DELETE /api/media/{media}
    public function destroy(Media $media): JsonResponse
    {
        $media->delete();

        return response()->json(['message' => 'Media berhasil dihapus']);
    }
}
