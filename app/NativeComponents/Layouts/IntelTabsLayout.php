<?php

namespace App\NativeComponents\Layouts;

use App\Icons\Android;
use App\Icons\Ios;
use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\Builders\Tab;
use Native\Mobile\Edge\Layouts\Builders\TabBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

/**
 * Root chrome for the Driver-to-Driver tab screens (feed + map): native
 * NavigationStack/TabView with the High-Vis wordmark up top and the
 * five-tab bar below. Bar colors read from the published theme tokens so
 * the chrome re-skins with the config — the builders take raw color
 * strings, so we resolve tokens here instead of hardcoding hex.
 *
 * Inbox and Profile are visual-only in this demo: `Tab::action()` with no
 * press handler renders the tab but taps do nothing.
 */
class IntelTabsLayout extends NativeLayout
{
    protected ?string $font = 'headline';

    public function usesNativeChrome(): bool
    {
        return true;
    }

    public function navBar(NativeComponent $screen): ?NavBar
    {
        return NavBar::make()
            ->title('DRIVER-TO-DRIVER')
            ->backgroundColor(config('native-ui.theme.light.background'))
            ->textColor(config('native-ui.theme.light.accent'))
            ->back(false);
    }

    public function tabBar(NativeComponent $screen): ?TabBar
    {
        return TabBar::make()
            ->backgroundColor(config('native-ui.theme.light.background'))
            ->activeColor(config('native-ui.theme.light.primary'))
            ->textColor(config('native-ui.theme.light.secondary'))
            ->font('mono')
            ->add(Tab::link('Home', '/', ios: Ios::HouseFill, android: Android::Home))
            ->add(Tab::link('Search', '/intel/map', ios: Ios::Magnifyingglass, android: Android::Search))
            ->add(Tab::action('Alert', ios: Ios::BellFill, android: Android::Notifications)->press('openReport'))
            ->add(Tab::action('Inbox', ios: Ios::TrayFill, android: Android::Inbox))
            ->add(Tab::action('Profile', ios: Ios::PersonFill, android: Android::Person));
    }
}
