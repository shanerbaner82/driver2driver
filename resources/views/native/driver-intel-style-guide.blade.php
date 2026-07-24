@use('App\Icons\Ios')
@use('App\Icons\Android')

<stack class="w-full h-full bg-theme-background">
    <scroll-view class="w-full h-full">
        <column class="w-full px-5 py-5 gap-6">

            {{-- ── Interactivity proof ─────────────────────────────── --}}
            <row class="w-full items-center rounded-md border border-theme-outline-variant bg-theme-surface p-4">
                <text font="mono" class="text-[14] text-theme-secondary">Button presses recorded</text>
                <spacer/>
                <text font="mono-bold" class="text-[20] text-theme-accent">{{ $presses }}</text>
            </row>

            {{-- ── Theme token swatches ────────────────────────────── --}}
            <text font="headline" class="text-[24] text-theme-on-background">Theme Tokens</text>
            <column class="w-full gap-3">
                @foreach ($this->swatchTokens() as $token => $label)
                    <row :native:key="'swatch-'.$token" class="w-full items-center rounded-md bg-theme-{{ $token }} px-4 py-4 border border-theme-outline-variant">
                        <text font="mono-bold" class="text-[14] text-theme-on-{{ $token }}">{{ $label }}</text>
                        <spacer/>
                        <text font="mono" class="text-[12] text-theme-on-{{ $token }}">bg-theme-{{ $token }}</text>
                    </row>
                @endforeach
            </column>

            {{-- ── Outline vs outline-variant ──────────────────────── --}}
            <text font="headline" class="text-[24] text-theme-on-background">Outline vs Outline-Variant</text>
            <row class="w-full gap-4">
                <column class="flex-1 items-center gap-2 rounded-md border-2 border-theme-outline bg-theme-surface p-4">
                    <text font="mono-bold" class="text-[13] text-theme-on-surface-variant">outline</text>
                    <text font="body" class="text-[14] text-theme-secondary text-center">Warm brand edges</text>
                </column>
                <column class="flex-1 items-center gap-2 rounded-md border-2 border-theme-outline-variant bg-theme-surface p-4">
                    <text font="mono-bold" class="text-[13] text-theme-on-surface-variant">outline-variant</text>
                    <text font="body" class="text-[14] text-theme-secondary text-center">Neutral card seams</text>
                </column>
            </row>

            {{-- ── Opacity modifiers on theme classes ──────────────── --}}
            <text font="headline" class="text-[24] text-theme-on-background">Theme Opacity Ramp</text>
            <column class="w-full gap-2">
                <row class="w-full gap-2">
                    @foreach ($this->opacitySteps() as $step)
                        <column :native:key="'op-primary-'.$step" class="flex-1 items-center rounded bg-theme-primary/{{ $step }} py-4">
                            <text font="mono" class="text-[11] text-theme-on-background">/{{ $step }}</text>
                        </column>
                    @endforeach
                </row>
                <row class="w-full gap-2">
                    @foreach ($this->opacitySteps() as $step)
                        <column :native:key="'op-success-'.$step" class="flex-1 items-center rounded bg-theme-success/{{ $step }} py-4">
                            <text font="mono" class="text-[11] text-theme-on-background">/{{ $step }}</text>
                        </column>
                    @endforeach
                </row>
                <text font="body" class="text-[13] text-theme-secondary">bg-theme-primary/N and bg-theme-success/N — tonal fills straight from tokens.</text>
            </column>

            {{-- ── Button variants (incl. new success) ─────────────── --}}
            <text font="headline" class="text-[24] text-theme-on-background">Button Variants</text>
            <column class="w-full gap-3">
                @foreach ($this->buttonVariants() as $buttonVariant)
                    <native:button :native:key="'btn-'.$buttonVariant" variant="{{ $buttonVariant }}" @press="recordPress"
                                   a11y-label="Demo button: {{ $buttonVariant }}" class="w-full">
                        variant="{{ $buttonVariant }}"
                    </native:button>
                @endforeach
                <native:button variant="success" disabled a11y-label="Disabled success button" class="w-full">
                    success + disabled
                </native:button>
                <native:button variant="success" class="glass:prominent w-full" @press="recordPress"
                               a11y-label="Glass success button">
                    success + glass:prominent (iOS 26)
                </native:button>
            </column>

            {{-- ── Badge variants (incl. new success) ──────────────── --}}
            <text font="headline" class="text-[24] text-theme-on-background">Badge Variants</text>
            <row class="w-full items-center gap-4 flex-wrap">
                @foreach ($this->badgeVariants() as $badgeVariant)
                    <column :native:key="'badge-'.$badgeVariant" class="items-center gap-2">
                        <native:badge variant="{{ $badgeVariant }}" label="{{ strtoupper($badgeVariant) }}"/>
                        <native:badge variant="{{ $badgeVariant }}" :count="12"/>
                    </column>
                @endforeach
            </row>

            {{-- ── Status patterns built from the new tokens ───────── --}}
            <text font="headline" class="text-[24] text-theme-on-background">Status Patterns</text>
            <row class="w-full rounded-lg overflow-hidden border border-theme-outline-variant bg-theme-surface">
                <column class="w-2 self-stretch bg-theme-success"/>
                <column class="flex-1 p-4 gap-1">
                    <text font="mono-bold" class="text-[13] tracking-wide text-theme-on-surface-variant">VERIFIED PATTERN</text>
                    <row class="items-center gap-2">
                        <icon :size="16" class="text-theme-success" :ios="Ios::CheckmarkCircle" :android="Android::CheckCircle"/>
                        <text font="body" class="text-[15] text-theme-success">text-theme-success + bg-theme-success bar</text>
                    </row>
                </column>
                <column class="justify-center pr-4">
                    <row class="items-center gap-2 px-3 py-2 rounded-lg bg-theme-success">
                        <text font="mono-bold" class="text-[12] text-theme-on-success">OPEN</text>
                    </row>
                </column>
            </row>

            {{-- ── Font aliases ────────────────────────────────────── --}}
            <text font="headline" class="text-[24] text-theme-on-background">Font Aliases</text>
            <column class="w-full gap-3 rounded-md border border-theme-outline-variant bg-theme-surface p-4">
                @foreach ($this->fontSamples() as $alias => $sample)
                    <column :native:key="'font-'.$alias" class="w-full gap-1">
                        <text font="mono" class="text-[11] text-theme-on-surface-variant">font="{{ $alias }}"</text>
                        <text font="{{ $alias }}" class="text-[17] text-theme-on-surface">{{ $sample }}</text>
                    </column>
                @endforeach
            </column>

            {{-- ── theme() helper note ─────────────────────────────── --}}
            <column class="w-full gap-2 rounded-md border border-theme-outline bg-theme-surface p-4 mb-4">
                <text font="mono-bold" class="text-[13] text-theme-on-surface-variant">CHROME VIA theme()</text>
                <text font="body" class="text-[14] leading-relaxed text-theme-secondary">
                    This screen's nav bar colors come from theme('background') / theme('accent') in
                    IntelStackLayout — repaint the whole app from config/native-ui.php.
                </text>
            </column>
        </column>
    </scroll-view>
</stack>
