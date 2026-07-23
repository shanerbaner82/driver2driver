<?php

namespace App\NativeComponents;

use App\Models\IntelLocation;
use App\Models\IntelPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Native\Mobile\Attributes\Computed;
use Native\Mobile\Edge\NativeComponent;

class DriverIntelLocation extends NativeComponent
{
    public function navTitle(): string
    {
        return 'LOCATION DETAIL';
    }

    /** @var array<int, int> Post ids this driver already marked helpful. */
    public array $voted = [];

    public function markHelpful(int $postId): void
    {
        if (in_array($postId, $this->voted, true)) {
            return;
        }

        IntelPost::whereKey($postId)->increment('helpful_count');
        $this->voted[] = $postId;
    }

    #[Computed]
    public function location(): IntelLocation
    {
        return IntelLocation::findOrFail($this->param('id'));
    }

    /**
     * @return Collection<int, IntelPost>
     */
    #[Computed]
    public function intel(): Collection
    {
        return $this->location->posts()->latest()->get();
    }

    /** Filled-star count for the 5-star rating row. */
    public function filledStars(): int
    {
        return (int) round($this->location->rating ?? 0);
    }

    public function render(): View
    {
        return view('native.driver-intel-location');
    }
}
