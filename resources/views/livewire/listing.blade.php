<?php
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\TourismBusiness;


new
#[Layout('components.layouts.welcome')]
class extends Component {

    public $listing, $prevBusiness, $nextBusiness;
    
    public function mount(string $slug)
    {
        $business = TourismBusiness::where('slug', $slug)->firstOrfail();

        $id = $business->id;

        $this->listing = TourismBusiness::where('slug', $slug)->firstOrFail();

        $this->prevBusines = TourismBusiness::findOrFail($id);

        $this->nextBusiness = TourismBusiness::where('id', '>', $id)
            ->orderBy('id', 'asc')
            ->value('id');
    }

}; ?>

<div class="max-w-6xl mx-auto px-4 pb-8">

    <img class="dark:hidden md:hidden" src="{{ Storage::url('black-logo.avif') }}" alt="">
    <img class="dark:block hidden md:dark:hidden" src="{{ Storage::url('white-logo.png') }}" alt="">

    <!-- Header Section -->
   <div class="mb-5">
        <flux:button 
            href="{{ route('home') }}" 
            variant="filled"
        >
            Back To Home
        </flux:button>
    </div>

    <div class="relative w-full h-64 rounded-xl overflow-hidden shadow-xl mb-6">
    <!-- Cover Image Background -->

    

        @if($listing->cover_image)
            <img 
            src="{{ Storage::url($listing->cover_image) }}" 
            alt="{{ $listing->name }} cover image"
            class="absolute inset-0 w-full h-full object-cover"
            loading="lazy"
            >
        @else
            <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            </div>
        @endif
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
        
        <!-- Content Overlay -->
        <div class="relative h-full flex flex-col justify-end p-6 text-white">
            <div class="flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold drop-shadow-md">{{ $listing->name }}</h1>
                
                <div class="flex items-center mt-2">
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
                    {{ $listing->business_type }}
                </span>
                @if($listing->is_featured)
                <span class="ml-2 bg-yellow-100 text-yellow-800 text-sm font-medium px-2.5 py-0.5 rounded">
                    Featured
                </span>
                @endif
                </div>
                
                {{-- <div class="mt-2 flex items-center">
                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm drop-shadow-sm">
                    {{ number_format($listing->average_rating, 1) }} ({{ $listing->review_count }} reviews)
                </span>
                </div> --}}
            </div>
            
            @if ($listing->price_range)
                <div class="text-right">
                    <p class="text-xl font-bold drop-shadow-md">{{ $listing->price_range }} ZAR</p>
                    <p class="text-sm drop-shadow-sm">per night</p>
                </div>
            @endif
            </div>
        </div>
        </div>

        <!-- Categories below the header (optional) -->
        @if($listing->category)
        <div class="flex flex-wrap gap-2 -mt-3 mb-6 px-2">
        @foreach(json_decode($listing->category) as $category)
            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
            {{ $category }}
            </span>
        @endforeach
        </div>
    @endif

    @if(!$listing->cover_image)
        <div class="animate-pulse bg-gray-200 w-full h-full"></div>
    @endif

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2">
            <!-- Description -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">About</h2>
                <p class="text-gray-700 dark:text-white leading-relaxed">{{ $listing->description }}</p>
            </div>

            <!-- Amenities -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Amenities</h2>
                <div class="flex gap-2 flex-wrap gap-4">
                    @if($listing->parking)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Parking</span>
                        </div>
                    @endif
                    @if($listing->pool)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Swimming Pool</span>
                        </div>
                    @endif
                    @if($listing->restaurant)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Restaurant</span>
                        </div>
                    @endif
                    @if($listing->bar)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Bar</span>
                        </div>
                    @endif
                    @if($listing->pet_friendly)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Pet Friendly</span>
                        </div>
                    @endif
                    @if($listing->accepts_credit_card)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Credit Cards</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Image Gallery -->
    @if ($listing->images)
        @php
            $imageArray = json_decode($listing->images);
            $imageUrls = array_map(fn($img) => Storage::url($img), $imageArray);
        @endphp

                <h2 class="text-xl font-semibold mb-4">Gallery</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8" 
            x-data="{
                open: false,
                currentIndex: 0,
                images: @js($imageUrls),
                get currentImage() {
                    return this.images[this.currentIndex];
                },
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                },
                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                }
            }">
            
            <!-- Thumbnails -->
            @foreach($imageArray as $index => $image)
                <div class="rounded-lg overflow-hidden shadow-md cursor-pointer transition duration-300 hover:shadow-lg"
                    @click="open = true; currentIndex = {{ $index }}">
                    <img src="{{ Storage::url($image) }}" 
                        alt="{{ $listing->name }}" 
                        class="w-full h-50 object-cover hover:scale-105 transition duration-300">
                </div>
            @endforeach

            <!-- Image Modal -->
            <div x-show="open" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75"
                @click.away="open = false"
                @keydown.escape.window="open = false">
                
                <div class="relative w-full max-w-6xl max-h-[90vh]">
                    <!-- Close Button -->
                    <button @click="open = false" 
                            class="absolute -top-10 right-0 text-white hover:text-gray-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <!-- Main Image -->
                    <img x-bind:src="currentImage" 
                        alt="{{ $listing->name }}" 
                        class="w-full h-full object-contain max-h-[80vh] rounded-lg">
                    
                    <!-- Navigation Arrows -->
                    @if(count($imageArray) > 1)
                        <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 shadow-md hover:bg-opacity-100 transition"
                                @click.stop="prev()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 shadow-md hover:bg-opacity-100 transition"
                                @click.stop="next()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @endif
                    
                    <!-- Image Counter -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">
                        <span x-text="currentIndex + 1"></span>
                        /
                        <span x-text="images.length"></span>
                    </div>
                </div>
            </div>
        </div>
    @endif

            <!-- Services -->
            {{-- @if(json_decode($listing->services))
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Services</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach(json_decode($listing->services) as $service)
                            <span class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full">
                                {{ $service }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif --}}
        </div>

        <!-- Right Column (Contact & Location) -->
        <div class="lg:col-span-1">
            <div class=" rounded-lg shadow-md p-6 sticky top-4">
                <!-- Contact -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">Contact</h2>
                    <div class="space-y-3">
                        @if($listing->phone)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                <a href="tel:{{ $listing->phone }}" class="text-blue-600 hover:underline">{{ $listing->phone }}</a>
                            </div>
                        @endif
                        @if($listing->whatsapp)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                <a href="https://wa.me/{{ $listing->whatsapp }}" class="text-green-600 hover:underline">WhatsApp</a>
                            </div>
                        @endif
                        @if($listing->email)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                <a href="mailto:{{ $listing->email }}" class="text-blue-600 text-nowrap hover:underline">{{ $listing->email }}</a>
                            </div>
                        @endif
                        @if($listing->website)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ $listing->website }}" target="_blank" class="text-blue-600 hover:underline">Visit Website</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">Location</h2>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-medium">{{ $listing->address }}</p>
                                <p class="text-gray-600">{{ $listing->city }}, {{ $listing->country }}</p>
                            </div>
                        </div>
                    </div>
                    @if($listing->latitude && $listing->longitude)
                        <div class="mt-4 h-48 rounded-lg overflow-hidden">
                            <iframe 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                scrolling="no" 
                                marginheight="0" 
                                marginwidth="0" 
                                src="https://maps.google.com/maps?q={{ $listing->latitude }},{{ $listing->longitude }}&hl=es;z=14&amp;output=embed"
                            ></iframe>
                        </div>
                    @endif
                </div>

                <!-- Social Media -->
                @if($listing->facebook || $listing->instagram || $listing->tiktok)
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Follow Us</h2>
                        <div class="flex space-x-4">
                            @if($listing->facebook)
                                <a href="{{ $listing->facebook }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                    </svg>
                                </a>
                            @endif
                            @if($listing->instagram)
                                <a href="{{ $listing->instagram }}" target="_blank" class="text-pink-600 hover:text-pink-800">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                    </svg>
                                </a>
                            @endif
                            @if($listing->tiktok)
                                <a href="{{ $listing->tiktok }}" target="_blank" class="text-gray-800 hover:text-black">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- <div class="flex gap-2">
            @if($prevBusiness)
                <flux:button 
                    class="w-1/2" 
                    href="{{ route('listing', ['slug' => $prevBusiness->slug]) }}" 
                    variant="filled"
                >
                    Prev
                </flux:button>
            @endif
            @if($nextBusiness)
                <flux:button 
                    class="w-1/2" 
                    href="{{ route('listing', ['slug' => $$nextBusiness->slug]) }}" 
                    variant="filled"
                    >
                    Next
                </flux:button>
            @endif
        </div> --}}
    </div>
</div>
