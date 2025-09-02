<?php

use Livewire\Volt\Component;
use App\Models\TourismBusiness;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    
    public $search = '';
    public $selectedBusiness = null;
    public $locations = [];
    

    public function getBusinessesProperty()
    {
        return TourismBusiness::when($this->search, function($query) {
            $search = $this->search;
            $query->where('name', 'like', '%'.$search.'%')
                  ->orWhere('city', 'like', '%'.$search.'%');
        })->latest()->paginate(5);
    }

    // formating data from computed properties
    // public function getMapLocationsProperty()
    // {
    //     return $this->businesses->map(function ($business) {
    //         return [
    //             'latitude' => $business->latitude,
    //             'longitude' => $business->longitude,
    //             'name' => $business->name,
    //             'image' => 'https://placehold.co/600x400',
    //         ]; 
    //     })->toArray();
    // }

    public function selectBusiness($businessId)
    {
        $this->selectedBusiness = TourismBusiness::find($businessId);
    }
}; ?>

<div class="relative">
    
        <!-- Left Column - Business List -->
        <div class="">
            <div class="bg-white dark:bg-zinc-800 z-10 p-4 border-b border-gray-200 sticky top-0">
                <a wire:navigate href="{{ route('home') }}">
                    <img class="dark:hidden" src="{{ Storage::url('black-logo.avif') }}" alt="">
                    <img class="hidden dark:block" src="{{ Storage::url('white-logo.png') }}" alt="">
                </a>
                <input 
                    wire:model.live="search"
                    placeholder="Search..." 
                    class="mt-2 w-full p-2 border rounded-xl"
                >
            </div>
            
            <div class="divide-y divide-gray-500 sticky top-0">
                <div class="grid  grid-cols-1 gap-6 mt-5">
                    @foreach($this->businesses as $business)
                        <a wire:navigate href="{{ route('listing', ['slug' => $business->slug]) }}" 
                        wire:click="selectBusiness({{ $business->id }})"
                        class="block relative group rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 {{ $selectedBusiness?->id === $business->id ? 'ring-2 ring-blue-500' : '' }}">
                            
                            <!-- Cover Image Background -->
                            <div class="relative h-48 w-full">
                                @if($business->cover_image)
                                    <img 
                                        src="{{ Storage::url($business->cover_image) }}" 
                                        alt="{{ $business->name }} cover image"
                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                                
                                <!-- Content Overlay -->
                                <div class="absolute bottom-0 left-0 w-full p-4 text-white">
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <h3 class="text-xl font-bold drop-shadow-md">{{ $business->name }}</h3>
                                            <p class="text-sm drop-shadow-sm">{{ $business->city }}</p>
                                        </div>
                                        
                                        {{-- <div class="flex items-center bg-black/30 px-2 py-1 rounded-full backdrop-blur-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($business->average_rating))
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @elseif($i == ceil($business->average_rating) && $business->average_rating != floor($business->average_rating))
                                                    <span class="text-yellow-400 text-xs">½</span>
                                                @else
                                                    <span class="text-yellow-400 text-xs">☆</span>
                                                @endif
                                            @endfor
                                            <span class="text-xs ml-1">
                                                ({{ $business->review_count }})
                                            </span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            
            
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $this->businesses->links() }}
        </div>
</div>




