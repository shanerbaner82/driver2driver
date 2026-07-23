@use('App\Icons\Ios')
@use('App\Icons\Android')

{{-- One feed card. Left status bar communicates the category before the
     text is read (DESIGN.md). Expects $post and $voted. --}}
<row class="w-full rounded-md overflow-hidden border border-theme-surface-variant bg-theme-surface">
    <column class="w-2 self-stretch {{ $post->category->barClass() }}"/>
    <column class="flex-1 p-4 gap-3">
        <row class="w-full items-center gap-2">
            <icon :size="18" class="{{ $post->category->accentClass() }}" :ios="$post->category->iosIcon()" :android="$post->category->androidIcon()"/>
            <text font="mono-bold" class="text-[13] tracking-wide {{ $post->category->accentClass() }}">{{ $post->category->label() }}</text>
            <spacer/>
            <text font="mono" class="text-[12] text-theme-on-surface-variant">{{ $post->timeAgo() }}</text>
        </row>

        <text font="body-bold" class="text-[19] leading-snug text-theme-on-surface">{{ $post->note }}</text>

        <column class="w-full h-px bg-theme-surface-variant"/>

        <row class="w-full items-center">
            <text font="mono" class="text-[13] text-theme-secondary">By {{ $post->driver_handle }}</text>
            <spacer/>
            <pressable ref="helpful-{{ $post->id }}" @press="markHelpful({{ $post->id }})"
                       a11y-label="Mark helpful: {{ $post->category->label() }} by {{ $post->driver_handle }}">
                <row class="items-center gap-2 px-4 py-3 rounded-md border {{ in_array($post->id, $voted, true) ? 'border-theme-primary bg-theme-surface-variant' : 'border-theme-outline' }}">
                    <icon :size="16" class="text-theme-on-surface"
                          :ios="in_array($post->id, $voted, true) ? Ios::HandThumbsupFill : Ios::HandThumbsup"
                          :android="in_array($post->id, $voted, true) ? Android::ThumbUp : Android::ThumbUpOffAlt"/>
                    <text font="mono-bold" class="text-[13] text-theme-on-surface">Helpful? ({{ $post->helpful_count }})</text>
                </row>
            </pressable>
        </row>
    </column>
</row>
