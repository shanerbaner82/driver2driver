<?php

use App\NativeComponents\DriverIntelFeed;
use App\NativeComponents\DriverIntelLocation;
use App\NativeComponents\DriverIntelMap;
use App\NativeComponents\DriverIntelReport;
use Illuminate\Support\Facades\Route;

// Driver-to-Driver — delivery intel drivers share in seconds.
// Chrome-less screens: each draws its own High-Vis header + bottom nav,
// so no NativeLayout is attached.
Route::native('/', DriverIntelFeed::class);
Route::native('/intel/map', DriverIntelMap::class);
Route::native('/intel/report', DriverIntelReport::class);
Route::native('/intel/location/{id}', DriverIntelLocation::class);
