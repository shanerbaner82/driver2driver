<?php

namespace App\NativeComponents;

use App\IntelCategory;
use App\Models\IntelLocation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Native\Mobile\Attributes\Computed;
use Native\Mobile\Edge\NativeComponent;

class DriverIntelMap extends NativeComponent
{
    /** Active pin filter — an IntelCategory value, or 'all'. */
    public string $filter = 'all';

    public function setFilter(string $filter): void
    {
        // Tapping the active chip clears the filter — one less tap to undo.
        $this->filter = $this->filter === $filter ? 'all' : $filter;
    }

    /**
     * @return Collection<int, IntelLocation>
     */
    #[Computed]
    public function locations(): Collection
    {
        return IntelLocation::query()
            ->whereNotNull('map_x')
            ->when($this->filter !== 'all', fn ($query) => $query->where('pin_category', $this->filter))
            ->get();
    }

    /**
     * Pin filter chips shown in the bottom panel.
     *
     * @return array<string, string>
     */
    public function filters(): array
    {
        return [
            IntelCategory::CleanBathroom->value => 'Bathrooms',
            IntelCategory::BuildingAccess->value => 'Access',
            IntelCategory::DogAlert->value => 'Dogs',
        ];
    }

    public function render(): View
    {
        return view('native.driver-intel-map');
    }
}
