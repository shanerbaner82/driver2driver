<?php

use App\NativeComponents\DriverIntelFeed;
use App\NativeComponents\DriverIntelLocation;
use App\NativeComponents\DriverIntelMap;
use App\NativeComponents\DriverIntelReport;
use App\NativeComponents\DriverIntelStyleGuide;
use App\NativeComponents\Layouts\IntelStackLayout;
use App\NativeComponents\Layouts\IntelTabsLayout;
use Illuminate\Support\Facades\Route;

// Driver-to-Driver — delivery intel drivers share in seconds.
// Tab screens share the High-Vis native chrome (nav bar + tab bar);
// pushed screens get the stack chrome with auto-back.
Route::nativeGroup(IntelTabsLayout::class, function (): void {
    Route::native('/', DriverIntelFeed::class);
    Route::native('/intel/map', DriverIntelMap::class);
});

Route::nativeGroup(IntelStackLayout::class, function (): void {
    Route::native('/intel/report', DriverIntelReport::class);
    Route::native('/intel/location/{id}', DriverIntelLocation::class);
    // Living style guide — exercises every theme token, opacity ramp,
    // font alias, and button/badge variant for on-device verification.
    Route::native('/intel/style-guide', DriverIntelStyleGuide::class);
});
