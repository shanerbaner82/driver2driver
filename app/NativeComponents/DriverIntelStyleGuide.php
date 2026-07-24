<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Living style guide for the High-Vis design system — exercises every
 * theme capability end-to-end on device so token, opacity, font-alias,
 * and variant changes (nativephp/mobile-ui PR #15) can be verified on
 * both platforms before merging.
 */
class DriverIntelStyleGuide extends NativeComponent
{
    /** Incremented by every demo button — proves variants stay interactive. */
    public int $presses = 0;

    public function navTitle(): string
    {
        return 'STYLE GUIDE';
    }

    public function recordPress(): void
    {
        $this->presses++;
    }

    /**
     * Token pairs rendered as swatches: bg token → its on-* companion.
     *
     * @return array<string, string>
     */
    public function swatchTokens(): array
    {
        return [
            'primary' => 'Safety Orange',
            'secondary' => 'Asphalt Gray',
            'surface' => 'Surface',
            'surface-variant' => 'Surface Variant',
            'destructive' => 'Destructive',
            'success' => 'Signal Green (custom)',
            'accent' => 'Peach Accent',
        ];
    }

    /**
     * Button variants including the new success case.
     *
     * @return array<int, string>
     */
    public function buttonVariants(): array
    {
        return ['primary', 'secondary', 'success', 'destructive', 'ghost'];
    }

    /**
     * Badge variants including the new success case.
     *
     * @return array<int, string>
     */
    public function badgeVariants(): array
    {
        return ['destructive', 'primary', 'success', 'accent'];
    }

    /**
     * Opacity steps for the theme-class tonal-fill ramp.
     *
     * @return array<int, int>
     */
    public function opacitySteps(): array
    {
        return [10, 25, 50, 75, 100];
    }

    /**
     * Font aliases from config/native-ui.php with sample copy.
     *
     * @return array<string, string>
     */
    public function fontSamples(): array
    {
        return [
            'headline' => 'HEADLINE — Archivo Narrow Bold',
            'body' => 'Body — Atkinson Hyperlegible for gate codes like 4492.',
            'body-bold' => 'Body Bold — emphasis without shouting.',
            'mono' => 'mono — Driver #892 @ 10:45 AM',
            'mono-bold' => 'MONO BOLD — CODE 1234#',
        ];
    }

    public function render(): View
    {
        return view('native.driver-intel-style-guide');
    }
}
