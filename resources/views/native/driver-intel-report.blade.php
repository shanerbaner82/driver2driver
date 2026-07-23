@use('App\Icons\Ios')
@use('App\Icons\Android')

<stack class="w-full h-full bg-[#121415]">
    <column class="w-full h-full safe-area">
        {{-- Header --}}
        <row class="w-full items-center px-4 py-3 bg-[#0C0E0F] border-b-2 border-[#5A4136]">
            <pressable ref="close-report" @navigate.back a11y-label="Close report">
                <column class="w-11 h-11 items-center justify-center">
                    <icon :size="22" class="text-[#E2E2E3]" :ios="Ios::Xmark" :android="Android::Close"/>
                </column>
            </pressable>
            <spacer/>
            <text font="ArchivoNarrow-Bold" class="text-[26] text-[#FFB693] tracking-wide">REPORT</text>
            <spacer/>
            <column class="w-11 h-11"/>
        </row>

        <scroll-view class="w-full flex-1">
            <column class="w-full px-5 py-5 gap-6">
                <text font="ArchivoNarrow-Bold" class="text-[24] text-[#E2E2E3]">Select Category</text>

                {{-- Oversized 2×2 category grid — one tap, gloved-hand sized --}}
                <column class="w-full gap-4">
                    @foreach (array_chunk($this->gridCategories(), 2) as $pair)
                        <row class="w-full gap-4">
                            @foreach ($pair as $gridCategory)
                                <pressable ref="category-{{ $gridCategory->value }}" @press="selectCategory('{{ $gridCategory->value }}')"
                                           a11y-label="Category: {{ $gridCategory->reportLabel() }}" class="flex-1">
                                    <column class="w-full h-44 items-center justify-center gap-4 rounded bg-[#1E2021] border-2 {{ $category === $gridCategory->value ? 'border-[#FF6B00] bg-[#282A2B]' : 'border-[#5A4136]' }}">
                                        <icon :size="44"
                                              class="{{ $category === $gridCategory->value ? 'text-[#FF6B00]' : 'text-[#E2E2E3]' }}"
                                              :ios="$gridCategory->iosIcon()" :android="$gridCategory->androidIcon()"/>
                                        <text font="JetBrainsMono-Bold" class="text-[15] {{ $category === $gridCategory->value ? 'text-[#FFB693]' : 'text-[#E2E2E3]' }}">
                                            {{ $gridCategory->reportLabel() }}
                                        </text>
                                    </column>
                                </pressable>
                            @endforeach
                        </row>
                    @endforeach
                </column>

                <text font="ArchivoNarrow-Bold" class="text-[24] text-[#E2E2E3]">Details</text>

                <stack class="w-full">
                    <bare-text-input native:model.blur="note" multiline min-lines="5" max-lines="8"
                                     placeholder="Add short note…" font="AtkinsonHyperlegible-Regular"
                                     a11y-label="Intel details"
                                     class="w-full p-4 rounded border-2 border-[#5A4136] bg-[#1A1C1D] text-[#E2E2E3] text-[17] leading-relaxed"/>
                    {{-- Voice-note affordance (visual only in this demo) --}}
                    <column class="absolute bottom-[12] right-[12] w-12 h-12 rounded-lg border border-[#A98A7D] bg-[#1E2021] items-center justify-center">
                        <icon :size="20" class="text-[#E2E2E3]" :ios="Ios::MicFill" :android="Android::Mic"/>
                    </column>
                </stack>
            </column>
        </scroll-view>

        {{-- Pinned primary action --}}
        <column class="w-full px-5 pb-4 pt-3">
            <pressable ref="post-intel" @press="postIntel" a11y-label="Post intel"
                       a11y-hint="Shares your report with nearby drivers" class="w-full">
                <row class="w-full h-16 rounded-lg bg-[#FF6B00] items-center justify-center gap-3 {{ $category === null || trim($note) === '' ? 'opacity-50' : '' }}">
                    <icon :size="22" class="text-[#0C0E0F]" :ios="Ios::PaperplaneFill" :android="Android::Send"/>
                    <text font="ArchivoNarrow-Bold" class="text-[22] text-[#0C0E0F] tracking-wide">POST INTEL</text>
                </row>
            </pressable>
        </column>
    </column>
</stack>
