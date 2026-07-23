<?php

namespace App\Models;

use App\IntelCategory;
use Database\Factories\IntelLocationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntelLocation extends Model
{
    /** @use HasFactory<IntelLocationFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
            'rating' => 'float',
            'code_verified_at' => 'datetime',
            'distance_km' => 'float',
            'pin_category' => IntelCategory::class,
            'tags' => 'array',
        ];
    }

    /**
     * @return HasMany<IntelPost, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(IntelPost::class);
    }

    /** "Verified 2h ago" line under the bathroom code. */
    public function codeVerifiedAgo(): ?string
    {
        return $this->code_verified_at?->diffForHumans(short: true);
    }
}
