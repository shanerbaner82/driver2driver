<?php

namespace App\Models;

use App\IntelCategory;
use Database\Factories\IntelPostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntelPost extends Model
{
    /** @use HasFactory<IntelPostFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => IntelCategory::class,
        ];
    }

    /**
     * @return BelongsTo<IntelLocation, $this>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(IntelLocation::class, 'intel_location_id');
    }

    /** Compact "2m ago" stamp for feed cards. */
    public function timeAgo(): string
    {
        return $this->created_at->diffForHumans(short: true);
    }

    /** "Today, 10:45 AM" style stamp for location-detail comments. */
    public function displayTime(): string
    {
        if ($this->created_at->isToday()) {
            return 'Today, '.$this->created_at->format('g:i A');
        }

        if ($this->created_at->isYesterday()) {
            return 'Yesterday, '.$this->created_at->format('g:i A');
        }

        return $this->created_at->format('M j, g:i A');
    }
}
