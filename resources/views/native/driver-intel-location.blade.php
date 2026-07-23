@use('App\Icons\Ios')
@use('App\Icons\Android')
@use('App\Icons\AndroidOutlined')

<stack class="w-full h-full bg-[#121415]">
    <column class="w-full h-full safe-area">
        {{-- Header --}}
        <row class="w-full items-center px-4 py-3 bg-[#0C0E0F] border-b-2 border-[#5A4136]">
            <pressable ref="back" @navigate.back a11y-label="Back">
                <column class="w-11 h-11 items-center justify-center">
                    <icon :size="22" class="text-[#E2E2E3]" :ios="Ios::ChevronLeft" :android="Android::ArrowBack"/>
                </column>
            </pressable>
            <spacer/>
            <text font="ArchivoNarrow-Bold" class="text-[26] text-[#FFB693] tracking-wide">LOCATION DETAIL</text>
            <spacer/>
            <column class="w-11 h-11 rounded-lg bg-[#282A2B] border border-[#A98A7D] items-center justify-center">
                <icon :size="20" class="text-[#E2E2E3]" :ios="Ios::PersonFill" :android="Android::Person"/>
            </column>
        </row>

        <scroll-view class="w-full flex-1">
            <column class="w-full px-5 py-5 gap-5">
                {{-- Name + open badge --}}
                <row class="w-full items-center gap-3">
                    <column class="flex-1 gap-1">
                        <text font="ArchivoNarrow-Bold" class="text-[30] text-[#E2E2E3]">{{ $this->location->name }}</text>
                        <text font="AtkinsonHyperlegible-Regular" class="text-[16] text-[#C5C7C9]">{{ $this->location->address }}</text>
                    </column>
                    @if ($this->location->is_open)
                        <row class="items-center gap-2 px-4 py-3 rounded-lg bg-[#00B059]">
                            <icon :size="18" class="text-[#003918]" :ios="Ios::CheckmarkCircle" :android="Android::CheckCircle"/>
                            <text font="JetBrainsMono-Bold" class="text-[14] text-[#003918]">OPEN</text>
                        </row>
                    @else
                        <row class="items-center gap-2 px-4 py-3 rounded-lg bg-[#93000A]">
                            <text font="JetBrainsMono-Bold" class="text-[14] text-[#FFDAD6]">CLOSED</text>
                        </row>
                    @endif
                </row>

                {{-- Tag + distance chips --}}
                <row class="w-full gap-3 flex-wrap">
                    @foreach ($this->location->tags as $tag)
                        <row class="items-center px-4 py-3 rounded-lg bg-[#282A2B]">
                            <text font="JetBrainsMono-Bold" class="text-[14] text-[#E2E2E3]">{{ $tag }}</text>
                        </row>
                    @endforeach
                    @if ($this->location->distance_km !== null)
                        <row class="items-center gap-2 px-4 py-3 rounded-lg bg-[#282A2B] border border-[#A98A7D]">
                            <icon :size="16" class="text-[#FFB693]" :ios="Ios::LocationFill" :android="Android::MyLocation"/>
                            <text font="JetBrainsMono-Bold" class="text-[14] text-[#FFB693]">{{ rtrim(rtrim(number_format($this->location->distance_km, 1), '0'), '.') }}km away</text>
                        </row>
                    @endif
                </row>

                {{-- Driver rating --}}
                @if ($this->location->rating !== null)
                    <column class="w-full items-center gap-3 rounded-lg bg-[#1E2021] border border-[#5A4136] p-5">
                        <text font="JetBrainsMono-Bold" class="text-[14] tracking-wide text-[#E2BFB0]">DRIVER RATING</text>
                        <row class="items-center gap-2">
                            @for ($star = 1; $star <= 5; $star++)
                                <icon :size="30"
                                      class="{{ $star <= $this->filledStars() ? 'text-[#FF6B00]' : 'text-[#5A4136]' }}"
                                      :ios="$star <= $this->filledStars() ? Ios::StarFill : Ios::Star"
                                      :android="$star <= $this->filledStars() ? Android::Star : AndroidOutlined::Star"/>
                            @endfor
                        </row>
                        <text font="ArchivoNarrow-Bold" class="text-[24] text-[#E2E2E3]">{{ number_format($this->location->rating, 1) }} / 5.0</text>
                    </column>
                @endif

                {{-- Bathroom code --}}
                @if ($this->location->bathroom_code !== null)
                    <row class="w-full rounded-lg overflow-hidden border border-[#3E4246] bg-[#141819]">
                        <column class="w-2 self-stretch bg-[#00E475]"/>
                        <column class="flex-1 p-5 gap-1">
                            <text font="JetBrainsMono-Bold" class="text-[14] tracking-wide text-[#E2BFB0]">BATHROOM CODE</text>
                            <text font="JetBrainsMono-Bold" class="text-[38] text-[#E2E2E3]">{{ $this->location->bathroom_code }}</text>
                            <row class="items-center gap-2">
                                <icon :size="16" class="text-[#00E475]" :ios="Ios::ClockFill" :android="Android::Schedule"/>
                                <text font="JetBrainsMono-Regular" class="text-[14] text-[#00E475]">Verified {{ $this->location->codeVerifiedAgo() }}</text>
                            </row>
                        </column>
                        <column class="justify-center pr-4">
                            <icon :size="56" class="text-[#282A2B]" :ios="Ios::KeyFill" :android="Android::Key"/>
                        </column>
                    </row>
                @endif

                {{-- Intel from drivers --}}
                <row class="w-full items-center gap-3 mt-1">
                    <icon :size="24" class="text-[#E2E2E3]" :ios="Ios::BubbleLeftFill" :android="Android::ChatBubble"/>
                    <text font="ArchivoNarrow-Bold" class="text-[24] text-[#E2E2E3]">Intel from Drivers</text>
                </row>

                @foreach ($this->intel as $post)
                    <column :native:key="'intel-'.$post->id" class="w-full rounded-md border border-[#5A4136] bg-[#161819] p-4 gap-2">
                        <row class="w-full items-center">
                            <text font="JetBrainsMono-Bold" class="text-[15] text-[#E2E2E3]">{{ $post->driver_handle }}</text>
                            <spacer/>
                            <text font="JetBrainsMono-Regular" class="text-[12] text-[#E2BFB0]">{{ $post->displayTime() }}</text>
                        </row>
                        <text font="AtkinsonHyperlegible-Regular" class="text-[17] leading-relaxed text-[#E2E2E3]">{{ $post->note }}</text>
                        <pressable ref="helpful-{{ $post->id }}" @press="markHelpful({{ $post->id }})"
                                   a11y-label="Mark helpful: note by {{ $post->driver_handle }}">
                            <row class="items-center gap-2 py-2">
                                <icon :size="16" class="text-[#C5C7C9]"
                                      :ios="in_array($post->id, $voted, true) ? Ios::HandThumbsupFill : Ios::HandThumbsup"
                                      :android="in_array($post->id, $voted, true) ? Android::ThumbUp : Android::ThumbUpOffAlt"/>
                                <text font="JetBrainsMono-Regular" class="text-[14] text-[#C5C7C9]">Helpful ({{ $post->helpful_count }})</text>
                            </row>
                        </pressable>
                    </column>
                @endforeach
            </column>
        </scroll-view>

        {{-- Pinned actions --}}
        <row class="w-full items-center gap-3 px-5 pb-4 pt-3 bg-[#0C0E0F] border-t-2 border-[#3E4246]">
            <pressable ref="photo" a11y-label="Add photo" @navigate.slideFromBottom('/intel/report')>
                <row class="items-center gap-2 h-14 px-5 rounded-lg bg-[#282A2B] border border-[#A98A7D]">
                    <icon :size="20" class="text-[#E2E2E3]" :ios="Ios::CameraFill" :android="Android::Camera"/>
                    <text font="ArchivoNarrow-Bold" class="text-[18] text-[#E2E2E3]">PHOTO</text>
                </row>
            </pressable>
            <pressable ref="update-status" @navigate.slideFromBottom('/intel/report') a11y-label="Update status" class="flex-1">
                <row class="w-full h-14 rounded-lg bg-[#FF6B00] items-center justify-center gap-2">
                    <icon :size="20" class="text-[#0C0E0F]" :ios="Ios::MegaphoneFill" :android="Android::Campaign"/>
                    <text font="ArchivoNarrow-Bold" class="text-[19] text-[#0C0E0F] tracking-wide">UPDATE STATUS</text>
                </row>
            </pressable>
        </row>
    </column>
</stack>
