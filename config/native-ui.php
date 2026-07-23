<?php

/**
 * Native UI — Theme Tokens
 *
 * Published via `php artisan vendor:publish --tag=native-ui-config`.
 * Edit to customize your app's visual identity in one place.
 *
 * For dynamic per-tenant theming, use Native\Mobile\UI\Theme::merge([...])
 * from a service provider. Runtime merges deep-merge on top of these values.
 *
 * Decision log: /docs/NATIVE-UI-REWRITE-PLAN.md (D — theme layer)
 */

return [

    /*
    |---------------------------------------------------------------------------
    | Theme
    |---------------------------------------------------------------------------
    |
    | 17 color tokens, 4 radii, 4 font sizes, font family.
    |
    | "on-X" means "color of content placed ON a surface of color X"
    |   — i.e., text/icons on that background.
    |
    | Color tokens accept:
    |   - CSS hex: '#B91C1C', '#F00', or with alpha '#8B5CF680' (#RRGGBBAA)
    |   - Tailwind palette names: 'red-300', 'orange-800'
    |   - Opacity modifiers on either: 'red-300/20', '#8B5CF6/50'
    |
    | Dark mode is auto-derived from `light` when `dark` is not set. To opt
    | into explicit dark tokens, fill out the `dark` block.
    |
    | The default pairs meet WCAG AA (4.5:1) — if you customize, keep each
    | `on-*` color at 4.5:1 contrast against its background token.
    |
    */

    'theme' => [

        /*
        | High-Vis Utility — dark-first industrial palette built for outdoor
        | visibility and night shifts. The brand commits to one look, so the
        | light and dark blocks are identical: deep asphalt surfaces, Safety
        | Orange reserved for primary actions, warm peach for wayfinding text.
        */
        'light' => [
            // Safety Orange — primary actions only. Must be impossible to miss.
            'primary' => '#FF6B00',
            'on-primary' => '#0C0E0F',

            // Asphalt Gray — muted text and secondary actions.
            'secondary' => '#C5C7C9',
            'on-secondary' => '#1A1C1D',

            // Surface = cards / sheets. Background = near-black asphalt root.
            'surface' => '#1E2021',
            'on-surface' => '#E2E2E3',
            'background' => '#121415',
            'on-background' => '#E2E2E3',

            // Elevated chips / filled inputs; warm muted labels on top.
            'surface-variant' => '#333536',
            'on-surface-variant' => '#E2BFB0',

            // Warm brand outline for borders and dividers.
            'outline' => '#5A4136',

            'destructive' => '#93000A',
            'on-destructive' => '#FFDAD6',

            // Peach tint — headlines, wayfinding, active-state text.
            'accent' => '#FFB693',
            'on-accent' => '#351000',
        ],

        'dark' => [
            'primary' => '#FF6B00',
            'on-primary' => '#0C0E0F',

            'secondary' => '#C5C7C9',
            'on-secondary' => '#1A1C1D',

            'surface' => '#1E2021',
            'on-surface' => '#E2E2E3',
            'background' => '#121415',
            'on-background' => '#E2E2E3',

            'surface-variant' => '#333536',
            'on-surface-variant' => '#E2BFB0',

            'outline' => '#5A4136',

            'destructive' => '#93000A',
            'on-destructive' => '#FFDAD6',

            'accent' => '#FFB693',
            'on-accent' => '#351000',
        ],

        // Corner radii (points / dp).
        'radius-sm' => 4,
        'radius-md' => 8,
        'radius-lg' => 16,
        'radius-full' => 9999,

        // Font size scale (points / sp).
        'font-sm' => 14,
        'font-md' => 16,
        'font-lg' => 20,
        'font-xl' => 24,

    ],

    /*
    |---------------------------------------------------------------------------
    | Font aliases
    |---------------------------------------------------------------------------
    |
    | Semantic names for bundled fonts (resources/fonts/ file tokens, minus
    | the extension). Use an alias anywhere a font token works — the `font`
    | attribute (`font="accent"`), chrome ->font() builders, or the layout
    | $font property. The special `default` alias sets the app-wide default
    | font (and supersedes the `font-family` token above).
    |
    |   'fonts' => [
    |       'default' => 'Inter-Regular',
    |       'accent'  => 'DynaPuff-Regular',
    |   ],
    |
    */

    'fonts' => [
        // Atkinson Hyperlegible body copy app-wide — distinct character
        // recognition for house numbers and gate codes.
        'default' => 'AtkinsonHyperlegible-Regular',
        'body' => 'AtkinsonHyperlegible-Regular',
        'body-bold' => 'AtkinsonHyperlegible-Bold',

        // Archivo Narrow — headlines and primary actions (more characters
        // per line for long addresses).
        'headline' => 'ArchivoNarrow-Bold',

        // JetBrains Mono — technical data: codes, timestamps, driver ids.
        'mono' => 'JetBrainsMono-Regular',
        'mono-bold' => 'JetBrainsMono-Bold',
    ],

];
