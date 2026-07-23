@use('App\Icons\Ios')
@use('App\Icons\Android')
@use('App\IntelCategory')

<stack class="w-full h-full bg-theme-background">
    <column class="w-full h-full">
        {{-- Category filter chips --}}
        <scroll-view axis="horizontal" class="w-full flex-none">
            <row class="px-4 py-3 gap-3 items-center">
                @foreach ($this->filters() as $key => $label)
                    @php $chipCategory = $key === 'all' ? null : IntelCategory::from($key); @endphp
                    <pressable ref="filter-{{ $key }}" @press="setFilter('{{ $key }}')" a11y-label="Filter alerts: {{ $label }}">
                        <row class="items-center gap-2 px-4 py-3 rounded-lg border-2 {{ $filter === $key ? 'border-theme-primary bg-theme-primary/15' : 'border-theme-outline-variant bg-theme-surface' }}">
                            <icon :size="18"
                                  class="{{ $filter === $key ? 'text-theme-accent' : ($chipCategory?->accentClass() ?? 'text-theme-accent') }}"
                                  :ios="$chipCategory?->iosIcon() ?? Ios::ExclamationmarkTriangleFill"
                                  :android="$chipCategory?->androidIcon() ?? Android::Warning"/>
                            <text font="mono-bold" class="text-[14] {{ $filter === $key ? 'text-theme-accent' : 'text-theme-on-surface' }}">{{ $label }}</text>
                        </row>
                    </pressable>
                @endforeach
            </row>
        </scroll-view>

        {{-- Intel feed --}}
        <scroll-view class="w-full flex-1">
            <column class="w-full px-4 pt-2 pb-5 gap-4">
                @if ($this->posts->isEmpty())
                    <text font="mono" class="w-full text-center text-[14] text-theme-on-surface-variant mt-10">
                        No alerts in this category yet.
                    </text>
                @endif

                @foreach ($this->posts as $post)
                    @if ($post->intel_location_id !== null)
                        <pressable :native:key="'post-'.$post->id" @navigate('/intel/location/'.$post->intel_location_id)
                                   a11y-label="Open location details for this alert" class="w-full">
                            @include('native.partials.intel-feed-card-body', ['post' => $post, 'voted' => $voted])
                        </pressable>
                    @else
                        <column :native:key="'post-'.$post->id" class="w-full">
                            @include('native.partials.intel-feed-card-body', ['post' => $post, 'voted' => $voted])
                        </column>
                    @endif
                @endforeach

                @if ($this->hasMore())
                    <pressable ref="load-more" @press="loadMore" a11y-label="Load more alerts" class="w-full mt-1">
                        <column class="w-full h-16 rounded-md bg-theme-primary items-center justify-center">
                            <text font="headline" class="text-[20] text-theme-on-primary tracking-wide">LOAD MORE ALERTS</text>
                        </column>
                    </pressable>
                @endif
            </column>
        </scroll-view>

    </column>
</stack>
