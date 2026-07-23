@use('App\Icons\Ios')
@use('App\Icons\Android')

{{-- One feed card. Left status bar communicates the category before the
     text is read (DESIGN.md). Expects $post and $voted. --}}
<row class="w-full rounded-md overflow-hidden border border-[#3E4246] bg-[#1E2021]">
    <column class="w-2 self-stretch {{ $post->category->barClass() }}"/>
    <column class="flex-1 p-4 gap-3">
        <row class="w-full items-center gap-2">
            <icon :size="18" class="{{ $post->category->accentClass() }}" :ios="$post->category->iosIcon()" :android="$post->category->androidIcon()"/>
            <text font="JetBrainsMono-Bold" class="text-[13] tracking-wide {{ $post->category->accentClass() }}">{{ $post->category->label() }}</text>
            <spacer/>
            <text font="JetBrainsMono-Regular" class="text-[12] text-[#A98A7D]">{{ $post->timeAgo() }}</text>
        </row>

        <text font="AtkinsonHyperlegible-Bold" class="text-[19] leading-snug text-[#E2E2E3]">{{ $post->note }}</text>

        <column class="w-full h-px bg-[#3E4246]"/>

        <row class="w-full items-center">
            <text font="JetBrainsMono-Regular" class="text-[13] text-[#C5C7C9]">By {{ $post->driver_handle }}</text>
            <spacer/>
            <pressable ref="helpful-{{ $post->id }}" @press="markHelpful({{ $post->id }})"
                       a11y-label="Mark helpful: {{ $post->category->label() }} by {{ $post->driver_handle }}">
                <row class="items-center gap-2 px-4 py-3 rounded-md border {{ in_array($post->id, $voted, true) ? 'border-[#FF6B00] bg-[#FF6B00]/15' : 'border-[#5A4136]' }}">
                    <icon :size="16" class="text-[#E2E2E3]"
                          :ios="in_array($post->id, $voted, true) ? Ios::HandThumbsupFill : Ios::HandThumbsup"
                          :android="in_array($post->id, $voted, true) ? Android::ThumbUp : Android::ThumbUpOffAlt"/>
                    <text font="JetBrainsMono-Bold" class="text-[13] text-[#E2E2E3]">Helpful? ({{ $post->helpful_count }})</text>
                </row>
            </pressable>
        </row>
    </column>
</row>
