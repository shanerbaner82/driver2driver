@use('App\Icons\Ios')
@use('App\Icons\Android')
@use('App\IntelCategory')

<stack class="w-full h-full bg-[#121415]">
    <column class="w-full h-full safe-area">
        @include('native.partials.intel-top-bar')

        {{-- Category filter chips --}}
        <scroll-view axis="horizontal" class="w-full flex-none">
            <row class="px-4 py-3 gap-3 items-center">
                @foreach ($this->filters() as $key => $label)
                    @php $chipCategory = $key === 'all' ? null : IntelCategory::from($key); @endphp
                    <pressable ref="filter-{{ $key }}" @press="setFilter('{{ $key }}')" a11y-label="Filter alerts: {{ $label }}">
                        <row class="items-center gap-2 px-4 py-3 rounded-lg border-2 {{ $filter === $key ? 'border-[#FF6B00] bg-[#FF6B00]/15' : 'border-[#3E4246] bg-[#1A1C1D]' }}">
                            <icon :size="18"
                                  class="{{ $filter === $key ? 'text-[#FFB693]' : ($chipCategory?->accentClass() ?? 'text-[#FFB693]') }}"
                                  :ios="$chipCategory?->iosIcon() ?? Ios::ExclamationmarkTriangleFill"
                                  :android="$chipCategory?->androidIcon() ?? Android::Warning"/>
                            <text font="JetBrainsMono-Bold" class="text-[14] {{ $filter === $key ? 'text-[#FFB693]' : 'text-[#E2E2E3]' }}">{{ $label }}</text>
                        </row>
                    </pressable>
                @endforeach
            </row>
        </scroll-view>

        {{-- Intel feed --}}
        <scroll-view class="w-full flex-1">
            <column class="w-full px-4 pt-2 pb-5 gap-4">
                @if ($this->posts->isEmpty())
                    <text font="JetBrainsMono-Regular" class="w-full text-center text-[14] text-[#A98A7D] mt-10">
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
                        <column class="w-full h-16 rounded-md bg-[#FF6B00] items-center justify-center">
                            <text font="ArchivoNarrow-Bold" class="text-[20] text-[#0C0E0F] tracking-wide">LOAD MORE ALERTS</text>
                        </column>
                    </pressable>
                @endif
            </column>
        </scroll-view>

        @include('native.partials.intel-bottom-nav', ['active' => 'home'])
    </column>
</stack>
