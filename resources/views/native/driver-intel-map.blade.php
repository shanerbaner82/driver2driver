@use('App\Icons\Ios')
@use('App\Icons\Android')
@use('App\IntelCategory')

<stack class="w-full h-full bg-theme-background">
    <column class="w-full h-full">
        {{-- Stylized map canvas — pins are positioned from seeded coords --}}
        <stack class="w-full flex-1 bg-[#9AA1A8] overflow-hidden">
            {{-- Faux street grid --}}
            <column class="absolute top-[90] left-0 w-full h-2 bg-[#B4BAC0]"/>
            <column class="absolute top-[300] left-0 w-full h-2 bg-[#B4BAC0]"/>
            <column class="absolute top-[430] left-0 w-full h-1 bg-[#B4BAC0]"/>
            <column class="absolute top-0 left-[80] w-2 h-full bg-[#B4BAC0]"/>
            <column class="absolute top-0 right-[100] w-1 h-full bg-[#B4BAC0]"/>

            @foreach ($this->locations as $pinLocation)
                <pressable :native:key="'pin-'.$pinLocation->id" @navigate('/intel/location/'.$pinLocation->id)
                           a11y-label="{{ $pinLocation->name }}, {{ $pinLocation->pin_category->label() }}"
                           class="absolute top-[{{ $pinLocation->map_y }}] left-[{{ $pinLocation->map_x }}]">
                    <column class="items-center">
                        <column class="w-14 h-14 rounded-xl border-[3px] border-theme-background items-center justify-center {{ $pinLocation->pin_category->pinClass() }}">
                            <icon :size="26" class="{{ $pinLocation->pin_category->pinIconClass() }}"
                                  :ios="$pinLocation->pin_category->iosIcon()" :android="$pinLocation->pin_category->androidIcon()"/>
                        </column>
                        <column class="w-1.5 h-4 {{ $pinLocation->pin_category->pinClass() }}"/>
                        <column class="w-4 h-1.5 rounded-full bg-[#1A1C1D]/50 mt-1"/>
                    </column>
                </pressable>
            @endforeach
        </stack>

        {{-- Bottom panel --}}
        <column class="w-full bg-theme-surface border-t-2 border-theme-outline px-5 pt-3 pb-4 gap-4">
            <row class="w-full justify-center">
                <column class="w-12 h-1.5 rounded-full bg-theme-on-surface-variant"/>
            </row>
            <row class="w-full items-center">
                <text font="headline" class="text-[24] text-theme-accent">Nearby Hacks</text>
                <spacer/>
                <pressable ref="add-intel" @navigate.slideFromBottom('/intel/report') a11y-label="Post new intel">
                    <column class="w-14 h-14 rounded-lg bg-theme-primary border-2 border-theme-background items-center justify-center">
                        <icon :size="28" class="text-theme-on-primary" :ios="Ios::Plus" :android="Android::Add"/>
                    </column>
                </pressable>
            </row>
            <row class="w-full gap-3">
                @foreach ($this->filters() as $key => $label)
                    @php $chipCategory = IntelCategory::from($key); @endphp
                    <pressable ref="map-filter-{{ $key }}" @press="setFilter('{{ $key }}')" a11y-label="Filter pins: {{ $label }}">
                        <row class="items-center gap-2 px-4 py-3 rounded-md border-2 {{ $filter === $key ? 'bg-theme-primary border-theme-primary' : 'border-theme-outline bg-theme-surface-variant' }}">
                            <icon :size="16" class="{{ $filter === $key ? 'text-theme-on-primary' : 'text-theme-on-surface' }}"
                                  :ios="$chipCategory->iosIcon()" :android="$chipCategory->androidIcon()"/>
                            <text font="mono-bold" class="text-[14] {{ $filter === $key ? 'text-theme-on-primary' : 'text-theme-on-surface' }}">{{ $label }}</text>
                        </row>
                    </pressable>
                @endforeach
            </row>
        </column>

    </column>
</stack>
