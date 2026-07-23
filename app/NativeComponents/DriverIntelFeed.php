<?php

namespace App\NativeComponents;

use App\IntelCategory;
use App\Models\IntelPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Native\Mobile\Attributes\Computed;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class DriverIntelFeed extends NativeComponent
{
    /** Active category filter — an IntelCategory value, or 'all'. */
    public string $filter = 'all';

    public int $limit = 6;

    /** @var array<int, int> Post ids this driver already marked helpful. */
    public array $voted = [];

    /** Alert tab: open the report screen as a bottom-sheet-style push. */
    public function openReport(): void
    {
        $this->navigate('/intel/report')->transition(Transition::SlideFromBottom);
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    public function loadMore(): void
    {
        $this->limit += 6;
    }

    public function markHelpful(int $postId): void
    {
        if (in_array($postId, $this->voted, true)) {
            return;
        }

        IntelPost::whereKey($postId)->increment('helpful_count');
        $this->voted[] = $postId;
    }

    /**
     * @return Collection<int, IntelPost>
     */
    #[Computed]
    public function posts(): Collection
    {
        return IntelPost::query()
            ->when($this->filter !== 'all', fn ($query) => $query->where('category', $this->filter))
            ->latest()
            ->take($this->limit)
            ->get();
    }

    public function hasMore(): bool
    {
        return IntelPost::query()
            ->when($this->filter !== 'all', fn ($query) => $query->where('category', $this->filter))
            ->count() > $this->limit;
    }

    /**
     * Filter chips: 'all' plus the categories drivers report most.
     *
     * @return array<string, string>
     */
    public function filters(): array
    {
        return [
            'all' => 'All Alerts',
            IntelCategory::BuildingAccess->value => 'Access',
            IntelCategory::DogAlert->value => 'Dogs',
            IntelCategory::CleanBathroom->value => 'Bathrooms',
            IntelCategory::TrafficParking->value => 'Traffic',
        ];
    }

    public function render(): View
    {
        return view('native.driver-intel-feed');
    }
}
