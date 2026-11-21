<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data awal sama seperti simulasi FlipPlay di Modul 3
        $list = [
            ['title' => 'Attack on Titan',    'type' => 'Anime', 'genre' => 'Action',  'score' => 9.1, 'episodes' => 89,   'vibe' => 'High Energy'],
            ['title' => 'Your Lie in April',  'type' => 'Anime', 'genre' => 'Drama',   'score' => 8.8, 'episodes' => 22,   'vibe' => 'Melancholy'],
            ['title' => 'One Piece',          'type' => 'Anime', 'genre' => 'Action',  'score' => 9.0, 'episodes' => 1100, 'vibe' => 'Binge Mode'],
        ];
        $media = collect($list)->map(fn (array $m) => Media::create($m));

        $ahmad = User::factory()->create([
            'name'  => 'Ahmad Nurul Hidayah',
            'email' => 'ahmad@flipplay.test',
        ]);
        $ahmad->media()->attach($media->pluck('id'));

        User::factory(2)->create();
    }
}
