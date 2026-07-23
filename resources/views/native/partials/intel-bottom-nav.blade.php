@use('App\Icons\Ios')
@use('App\Icons\Android')

{{-- Shared bottom nav. $active: 'home' | 'map'. Inbox and Profile are
     visual-only in this demo, so they render as plain (non-pressable)
     columns at reduced opacity. --}}
<row class="w-full items-center bg-[#0C0E0F] border-t-2 border-[#3E4246] px-2 pt-2 pb-1">
    <pressable @navigate.replace.fade('/') a11y-label="Home feed" class="flex-1">
        <column class="items-center gap-1 py-2 rounded-xl {{ $active === 'home' ? 'bg-[#FF6B00]/20' : '' }}">
            <icon :size="24" class="{{ $active === 'home' ? 'text-[#FF6B00]' : 'text-[#C5C7C9]' }}" :ios="Ios::HouseFill" :android="Android::Home"/>
            <text font="JetBrainsMono-Regular" class="text-[11] {{ $active === 'home' ? 'text-[#FF6B00]' : 'text-[#C5C7C9]' }}">Home</text>
        </column>
    </pressable>

    <pressable @navigate.replace.fade('/intel/map') a11y-label="Nearby map" class="flex-1">
        <column class="items-center gap-1 py-2 rounded-xl {{ $active === 'map' ? 'bg-[#FF6B00]/20' : '' }}">
            <icon :size="24" class="{{ $active === 'map' ? 'text-[#FF6B00]' : 'text-[#C5C7C9]' }}" :ios="Ios::Magnifyingglass" :android="Android::Search"/>
            <text font="JetBrainsMono-Regular" class="text-[11] {{ $active === 'map' ? 'text-[#FF6B00]' : 'text-[#C5C7C9]' }}">Search</text>
        </column>
    </pressable>

    <pressable @navigate.slideFromBottom('/intel/report') a11y-label="Post new intel" class="flex-1">
        <column class="items-center gap-1 py-2">
            <icon :size="24" class="text-[#C5C7C9]" :ios="Ios::BellFill" :android="Android::Notifications"/>
            <text font="JetBrainsMono-Regular" class="text-[11] text-[#C5C7C9]">Alert</text>
        </column>
    </pressable>

    <column class="flex-1 items-center gap-1 py-2 opacity-60">
        <icon :size="24" class="text-[#C5C7C9]" :ios="Ios::TrayFill" :android="Android::Inbox"/>
        <text font="JetBrainsMono-Regular" class="text-[11] text-[#C5C7C9]">Inbox</text>
    </column>

    <column class="flex-1 items-center gap-1 py-2 opacity-60">
        <icon :size="24" class="text-[#C5C7C9]" :ios="Ios::PersonFill" :android="Android::Person"/>
        <text font="JetBrainsMono-Regular" class="text-[11] text-[#C5C7C9]">Profile</text>
    </column>
</row>
