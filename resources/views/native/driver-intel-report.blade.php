@use('App\Icons\Ios')
@use('App\Icons\Android')

<stack class="w-full h-full bg-theme-background">
    <column class="w-full h-full">
        <scroll-view class="w-full flex-1">
            <column class="w-full px-5 py-5 gap-6">
                <text font="headline" class="text-[24] text-theme-on-surface">Select Category</text>

                {{-- Oversized 2×2 category grid — one tap, gloved-hand sized --}}
                <column class="w-full gap-4">
                    @foreach (array_chunk($this->gridCategories(), 2) as $pair)
                        <row class="w-full gap-4">
                            @foreach ($pair as $gridCategory)
                                <pressable ref="category-{{ $gridCategory->value }}" @press="selectCategory('{{ $gridCategory->value }}')"
                                           a11y-label="Category: {{ $gridCategory->reportLabel() }}" class="flex-1">
                                    <column class="w-full h-44 items-center justify-center gap-4 rounded bg-theme-surface border-2 {{ $category === $gridCategory->value ? 'border-theme-primary bg-theme-surface-variant' : 'border-theme-outline' }}">
                                        <icon :size="44"
                                              class="{{ $category === $gridCategory->value ? 'text-theme-primary' : 'text-theme-on-surface' }}"
                                              :ios="$gridCategory->iosIcon()" :android="$gridCategory->androidIcon()"/>
                                        <text font="mono-bold" class="text-[15] {{ $category === $gridCategory->value ? 'text-theme-accent' : 'text-theme-on-surface' }}">
                                            {{ $gridCategory->reportLabel() }}
                                        </text>
                                    </column>
                                </pressable>
                            @endforeach
                        </row>
                    @endforeach
                </column>

                <text font="headline" class="text-[24] text-theme-on-surface">Details</text>

                <stack class="w-full">
                    <bare-text-input native:model.blur="note" multiline min-lines="5" max-lines="8"
                                     placeholder="Add short note…" font="body"
                                     a11y-label="Intel details"
                                     class="w-full p-4 rounded border-2 border-theme-outline bg-theme-surface text-theme-on-surface text-[17] leading-relaxed"/>
                    {{-- Voice-note affordance (visual only in this demo) --}}
                    <column class="absolute bottom-[12] right-[12] w-12 h-12 rounded-lg border border-theme-outline bg-theme-surface items-center justify-center">
                        <icon :size="20" class="text-theme-on-surface" :ios="Ios::MicFill" :android="Android::Mic"/>
                    </column>
                </stack>
            </column>
        </scroll-view>

        {{-- Pinned primary action --}}
        <column class="w-full px-5 pb-4 pt-3">
            <pressable ref="post-intel" @press="postIntel" a11y-label="Post intel"
                       a11y-hint="Shares your report with nearby drivers" class="w-full">
                <row class="w-full h-16 rounded-lg bg-theme-primary items-center justify-center gap-3 {{ $category === null || trim($note) === '' ? 'opacity-50' : '' }}">
                    <icon :size="22" class="text-theme-on-primary" :ios="Ios::PaperplaneFill" :android="Android::Send"/>
                    <text font="headline" class="text-[22] text-theme-on-primary tracking-wide">POST INTEL</text>
                </row>
            </pressable>
        </column>
    </column>
</stack>
