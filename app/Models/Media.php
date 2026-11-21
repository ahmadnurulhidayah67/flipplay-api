<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = ['title', 'type', 'genre', 'score', 'episodes', 'vibe'];

    protected $casts = [
        'score'    => 'float',
        'episodes' => 'integer',
    ];

    // Many-to-many: satu media bisa ada di koleksi banyak pengguna
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // Query scope: pencarian berdasarkan judul
    public function scopeSearch(Builder $query, ?string $title): Builder
    {
        return $title ? $query->where('title', 'like', "%{$title}%") : $query;
    }
}
