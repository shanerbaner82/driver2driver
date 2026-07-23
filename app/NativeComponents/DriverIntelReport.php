<?php

namespace App\NativeComponents;

use App\IntelCategory;
use App\Models\IntelPost;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class DriverIntelReport extends NativeComponent
{
    /** Selected IntelCategory value; null until the driver picks one. */
    public ?string $category = null;

    public string $note = '';

    public function selectCategory(string $category): void
    {
        $this->category = $category;
    }

    public function postIntel(): void
    {
        if ($this->category === null || trim($this->note) === '') {
            return;
        }

        IntelPost::create([
            'category' => IntelCategory::from($this->category),
            'note' => trim($this->note),
            'driver_handle' => 'You',
        ]);

        $this->back();
    }

    /**
     * The 2×2 quick-report grid — the four highest-frequency categories.
     *
     * @return array<int, IntelCategory>
     */
    public function gridCategories(): array
    {
        return [
            IntelCategory::BuildingAccess,
            IntelCategory::CleanBathroom,
            IntelCategory::DogAlert,
            IntelCategory::GasPrice,
        ];
    }

    public function render(): View
    {
        return view('native.driver-intel-report');
    }
}
