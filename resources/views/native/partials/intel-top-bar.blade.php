@use('App\Icons\Ios')
@use('App\Icons\Android')

{{-- Shared Driver-to-Driver header: hamburger, wordmark, profile chip. --}}
<row class="w-full items-center px-4 py-3 bg-[#0C0E0F] border-b-2 border-[#5A4136]">
    <icon :size="26" class="text-[#E2E2E3]" :ios="Ios::Line3Horizontal" :android="Android::Menu"/>
    <spacer/>
    <text font="ArchivoNarrow-Bold" class="text-[26] text-[#FFB693] tracking-wide">DRIVER-TO-DRIVER</text>
    <spacer/>
    <column class="w-10 h-10 rounded-full bg-[#282A2B] border border-[#A98A7D] items-center justify-center">
        <icon :size="20" class="text-[#FFB693]" a11y-label="Your profile" :ios="Ios::PersonFill" :android="Android::Person"/>
    </column>
</row>
