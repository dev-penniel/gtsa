<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        
    </head>
    <body>
    <div class="flex-col-reverse sm:flex-row   mx-auto p-6 gap-6 flex gap-4">

        {{-- Hide component based on page and screen size --}}

        @if (request()->is('listing/*'))
            {{-- Listing pages: hidden on mobile --}}
            <div class="hidden md:block lg:w-1/4 min-w-4 ">
                <livewire:welcome-listings />
            </div>
        @elseif (request()->is('/'))
            {{-- Home page: always visible --}}
            <div class="block lg:w-1/4 min-w-4">
                <livewire:welcome-listings />
            </div>
        @else
            {{-- Other pages: normal responsive behavior --}}
            <div class="hidden md:block lg:w-1/4 min-w-4">
                <livewire:welcome-listings />
            </div>
        @endif

        <div class="w-full h-[400px] sm:w-3/4">
            {{ $slot }}
        </div>

    </div>

    <div class="p-4">
        {{-- {{ $this->businesses->links() }} --}}
    </div>

    @fluxScripts
    </body>
</html>

