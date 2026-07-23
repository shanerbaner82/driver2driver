@use('App\Icons\Ios')
@use('App\Icons\Android')
@use('App\Icons\AndroidOutlined')

<stack class="w-full h-full bg-theme-background">
    <column class="w-full h-full">
        <scroll-view class="w-full flex-1">
            <column class="w-full px-5 py-5 gap-5">
                {{-- Name + open badge --}}
                <row class="w-full items-center gap-3">
                    <column class="flex-1 gap-1">
                        <text font="headline" class="text-[30] text-theme-on-surface">{{ $this->location->name }}</text>
                        <text font="body" class="text-[16] text-theme-secondary">{{ $this->location->address }}</text>
                    </column>
                    @if ($this->location->is_open)
                        <row class="items-center gap-2 px-4 py-3 rounded-lg bg-theme-success">
                            <icon :size="18" class="text-theme-on-success" :ios="Ios::CheckmarkCircle" :android="Android::CheckCircle"/>
                            <text font="mono-bold" class="text-[14] text-theme-on-success">OPEN</text>
                        </row>
                    @else
                        <row class="items-center gap-2 px-4 py-3 rounded-lg bg-theme-destructive">
                            <text font="mono-bold" class="text-[14] text-theme-on-destructive">CLOSED</text>
                        </row>
                    @endif
                </row>

                {{-- Tag + distance chips --}}
                <row class="w-full gap-3 flex-wrap">
                    @foreach ($this->location->tags as $tag)
                        <row class="items-center px-4 py-3 rounded-lg bg-theme-surface-variant">
                            <text font="mono-bold" class="text-[14] text-theme-on-surface">{{ $tag }}</text>
                        </row>
                    @endforeach
                    @if ($this->location->distance_km !== null)
                        <row class="items-center gap-2 px-4 py-3 rounded-lg bg-theme-surface-variant border border-theme-outline">
                            <icon :size="16" class="text-theme-accent" :ios="Ios::LocationFill" :android="Android::MyLocation"/>
                            <text font="mono-bold" class="text-[14] text-theme-accent">{{ rtrim(rtrim(number_format($this->location->distance_km, 1), '0'), '.') }}km away</text>
                        </row>
                    @endif
                </row>

                {{-- Driver rating --}}
                @if ($this->location->rating !== null)
                    <column class="w-full items-center gap-3 rounded-lg bg-theme-surface border border-theme-outline p-5">
                        <text font="mono-bold" class="text-[14] tracking-wide text-theme-on-surface-variant">DRIVER RATING</text>
                        <row class="items-center gap-2">
                            @for ($star = 1; $star <= 5; $star++)
                                <icon :size="30"
                                      class="{{ $star <= $this->filledStars() ? 'text-theme-primary' : 'text-theme-outline' }}"
                                      :ios="$star <= $this->filledStars() ? Ios::StarFill : Ios::Star"
                                      :android="$star <= $this->filledStars() ? Android::Star : AndroidOutlined::Star"/>
                            @endfor
                        </row>
                        <text font="headline" class="text-[24] text-theme-on-surface">{{ number_format($this->location->rating, 1) }} / 5.0</text>
                    </column>
                @endif

                {{-- Bathroom code --}}
                @if ($this->location->bathroom_code !== null)
                    <row class="w-full rounded-lg overflow-hidden border border-theme-outline-variant bg-theme-surface">
                        <column class="w-2 self-stretch bg-theme-success"/>
                        <column class="flex-1 p-5 gap-1">
                            <text font="mono-bold" class="text-[14] tracking-wide text-theme-on-surface-variant">BATHROOM CODE</text>
                            <text font="mono-bold" class="text-[38] text-theme-on-surface">{{ $this->location->bathroom_code }}</text>
                            <row class="items-center gap-2">
                                <icon :size="16" class="text-theme-success" :ios="Ios::ClockFill" :android="Android::Schedule"/>
                                <text font="mono" class="text-[14] text-theme-success">Verified {{ $this->location->codeVerifiedAgo() }}</text>
                            </row>
                        </column>
                        <column class="justify-center pr-4">
                            <icon :size="56" class="text-theme-surface-variant" :ios="Ios::KeyFill" :android="Android::Key"/>
                        </column>
                    </row>
                @endif

                {{-- Intel from drivers --}}
                <row class="w-full items-center gap-3 mt-1">
                    <icon :size="24" class="text-theme-on-surface" :ios="Ios::BubbleLeftFill" :android="Android::ChatBubble"/>
                    <text font="headline" class="text-[24] text-theme-on-surface">Intel from Drivers</text>
                </row>

                @foreach ($this->intel as $post)
                    <column :native:key="'intel-'.$post->id" class="w-full rounded-md border border-theme-outline bg-theme-surface p-4 gap-2">
                        <row class="w-full items-center">
                            <text font="mono-bold" class="text-[15] text-theme-on-surface">{{ $post->driver_handle }}</text>
                            <spacer/>
                            <text font="mono" class="text-[12] text-theme-on-surface-variant">{{ $post->displayTime() }}</text>
                        </row>
                        <text font="body" class="text-[17] leading-relaxed text-theme-on-surface">{{ $post->note }}</text>
                        <pressable ref="helpful-{{ $post->id }}" @press="markHelpful({{ $post->id }})"
                                   a11y-label="Mark helpful: note by {{ $post->driver_handle }}">
                            <row class="items-center gap-2 py-2">
                                <icon :size="16" class="text-theme-secondary"
                                      :ios="in_array($post->id, $voted, true) ? Ios::HandThumbsupFill : Ios::HandThumbsup"
                                      :android="in_array($post->id, $voted, true) ? Android::ThumbUp : Android::ThumbUpOffAlt"/>
                                <text font="mono" class="text-[14] text-theme-secondary">Helpful ({{ $post->helpful_count }})</text>
                            </row>
                        </pressable>
                    </column>
                @endforeach
            </column>
        </scroll-view>

        {{-- Pinned actions --}}
        <row class="w-full items-center gap-3 px-5 pb-4 pt-3 bg-theme-background border-t-2 border-theme-outline-variant">
            <pressable ref="photo" a11y-label="Add photo" @navigate.slideFromBottom('/intel/report')>
                <row class="items-center gap-2 h-14 px-5 rounded-lg bg-theme-surface-variant border border-theme-outline">
                    <icon :size="20" class="text-theme-on-surface" :ios="Ios::CameraFill" :android="Android::Camera"/>
                    <text font="headline" class="text-[18] text-theme-on-surface">PHOTO</text>
                </row>
            </pressable>
            <pressable ref="update-status" @navigate.slideFromBottom('/intel/report') a11y-label="Update status" class="flex-1">
                <row class="w-full h-14 rounded-lg bg-theme-primary items-center justify-center gap-2">
                    <icon :size="20" class="text-theme-on-primary" :ios="Ios::MegaphoneFill" :android="Android::Campaign"/>
                    <text font="headline" class="text-[19] text-theme-on-primary tracking-wide">UPDATE STATUS</text>
                </row>
            </pressable>
        </row>
    </column>
</stack>
