<?php

use App\IntelCategory;
use App\Models\IntelPost;
use App\NativeComponents\DriverIntelFeed;
use App\NativeComponents\DriverIntelMap;
use App\NativeComponents\DriverIntelReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Native\Mobile\Testing\Native;

uses(RefreshDatabase::class);

it('renders the intel feed with seeded alerts accessibly', function () {
    Native::test(DriverIntelFeed::class)
        ->assertSee('All Alerts')
        ->assertSee('Dog Alert')
        ->assertSee('Aggressive dog loose in front yard')
        ->assertSee('By Driver #892')
        ->assertAccessible();
});

it('filters the feed by category', function () {
    Native::test(DriverIntelFeed::class)
        ->tap('filter-access')
        ->assertSet('filter', 'access')
        ->assertSee('Side Gate Unlocked')
        ->assertDontSee('Aggressive dog loose in front yard');
});

it('marks a post helpful exactly once', function () {
    $post = IntelPost::where('category', IntelCategory::DogAlert)->firstOrFail();

    $screen = Native::test(DriverIntelFeed::class)
        ->tap('helpful-'.$post->id)
        ->assertSee('Helpful? ('.($post->helpful_count + 1).')');

    // A second tap must not double-count.
    $screen->tap('helpful-'.$post->id);

    expect($post->refresh()->helpful_count)->toBe(13);
});

it('posts intel in seconds from the report screen', function () {
    Native::test(DriverIntelReport::class)
        ->assertSee('Select Category')
        ->tap('category-dog')
        ->assertSet('category', 'dog')
        ->set('note', 'Loose husky near the loading dock.')
        ->tap('post-intel');

    $post = IntelPost::latest('id')->first();

    expect($post->category)->toBe(IntelCategory::DogAlert)
        ->and($post->note)->toBe('Loose husky near the loading dock.')
        ->and($post->driver_handle)->toBe('You');
});

it('refuses to post without a category or note', function () {
    $before = IntelPost::count();

    Native::test(DriverIntelReport::class)
        ->set('note', 'Note without a category')
        ->tap('post-intel');

    Native::test(DriverIntelReport::class)
        ->tap('category-gas')
        ->tap('post-intel');

    expect(IntelPost::count())->toBe($before);
});

it('shows nearby pins on the map and filters them', function () {
    Native::test(DriverIntelMap::class)
        ->assertSee('Nearby Hacks')
        ->assertSee('Shell Gas Station')
        ->assertSee('Maple Court Apartments')
        ->tap('map-filter-bathroom')
        ->assertSee('Shell Gas Station')
        ->assertDontSee('Maple Court Apartments')
        ->assertAccessible();
});

it('tapping the active map filter clears it', function () {
    Native::test(DriverIntelMap::class)
        ->tap('map-filter-bathroom')
        ->tap('map-filter-bathroom')
        ->assertSet('filter', 'all')
        ->assertSee('Maple Court Apartments');
});

it('renders location details with rating, code, and driver intel', function () {
    Native::visit('/intel/location/1')
        ->assertSee('Shell Gas Station')
        ->assertSee('123 Highway 401 Eastbound')
        ->assertSee('OPEN')
        ->assertSee('DRIVER RATING')
        ->assertSee('4.5 / 5.0')
        ->assertSee('BATHROOM CODE')
        ->assertSee('1234#')
        ->assertSee('Mike T.')
        ->assertSee('Pumps 3 & 4 are out of order')
        ->assertAccessible();
});

it('renders the intel screens on Android too', function (string $component) {
    Native::test($component, platform: 'android')->assertAccessible();
})->with([
    'feed' => DriverIntelFeed::class,
    'report' => DriverIntelReport::class,
    'map' => DriverIntelMap::class,
]);
