<?php

use Native\Mobile\Edge\CallbackRegistry;
use Native\Mobile\Edge\TailwindParser;
use Nativephp\NativeUi\Elements\Badge;
use Nativephp\NativeUi\Elements\Button;

/**
 * Guards the High-Vis design system contract: every theme role used by the
 * views resolves through config/native-ui.php — including the app-defined
 * success / outline-variant tokens — and the theme() helper feeds chrome
 * builders from the same source of truth.
 */
it('resolves every theme token the views rely on', function (string $class, array $expected) {
    expect(TailwindParser::parse($class))->toBe($expected);
})->with([
    'background' => ['bg-theme-background', ['bg' => '#121415']],
    'surface' => ['bg-theme-surface', ['bg' => '#1E2021']],
    'primary' => ['bg-theme-primary', ['bg' => '#FF6B00']],
    'on-surface text' => ['text-theme-on-surface', ['color' => '#E2E2E3']],
    'accent text' => ['text-theme-accent', ['color' => '#FFB693']],
    'custom success' => ['bg-theme-success', ['bg' => '#00E475']],
    'custom on-success' => ['text-theme-on-success', ['color' => '#003918']],
    'custom outline-variant' => ['border-theme-outline-variant', ['borderColor' => '#3E4246', 'borderWidth' => 1]],
]);

it('supports opacity modifiers on theme classes for tonal fills', function () {
    expect(TailwindParser::parse('bg-theme-primary/15'))->toBe(['bg' => '#26FF6B00']);
});

it('feeds chrome colors through the appearance-aware theme() helper', function () {
    expect(theme('primary'))->toBe('#FF6B00')
        ->and(theme('success'))->toBe('#00E475')
        ->and(theme('missing-token', '#000000'))->toBe('#000000');
});

it('exposes the success variant on button and badge elements', function () {
    $button = Button::make()
        ->variant('success')
        ->toArray(new CallbackRegistry);

    $badge = Badge::make()
        ->variant('success')
        ->toArray(new CallbackRegistry);

    expect($button['props']['variant'])->toBe('success')
        ->and($badge['props']['variant'])->toBe('success');
});

it('registers the design-system font aliases', function () {
    expect(config('native-ui.fonts'))
        ->toHaveKey('headline', 'ArchivoNarrow-Bold')
        ->toHaveKey('mono', 'JetBrainsMono-Regular')
        ->toHaveKey('default', 'AtkinsonHyperlegible-Regular');
});
