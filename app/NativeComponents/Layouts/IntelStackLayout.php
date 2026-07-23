<?php

namespace App\NativeComponents\Layouts;

use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

/**
 * Chrome for pushed Driver-to-Driver screens (report, location detail):
 * a themed nav bar with auto-back, no tab bar. Titles come from each
 * screen's navTitle().
 */
class IntelStackLayout extends NativeLayout
{
    protected ?string $font = 'headline';

    public function usesNativeChrome(): bool
    {
        return true;
    }

    public function navBar(NativeComponent $screen): ?NavBar
    {
        return NavBar::make()
            ->title($screen->navTitle())
            ->backgroundColor(theme('background'))
            ->textColor(theme('accent'))
            ->back();
    }
}
