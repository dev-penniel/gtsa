<?php

use Livewire\Volt\Component;
use Illuminate\Support\Str;
use App\Models\TourismBusiness;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

new class extends Component {

    use WithPagination;
    use WithFileUploads;
    
    #[Validate('image|max:1024')] // 1MB Max
    public $coverImage;
    public $images = [];
    public $imagesToRemove = [];
    public $currentCoverImage, $currentImages;

    public $name, $originalName, $editedName, $slug, $id;
    public $search = '';
    public $description;
    public $business_type;
    public $category = [];
    public $is_featured = false;
    public $status = 'pending';
    public $phone;
    public $email;
    public $website;
    public $whatsapp;
    public $country;
    public $city;
    public $address;
    public $latitude;
    public $longitude;
    public $video_url;
    public $parking = false;
    public $pool = false;
    public $bar = false;
    public $restaurant = false;
    public $pet_friendly = false;
    public $price_range;
    public $currency = 'LSL';
    public $accepts_credit_card = true;
    public $facebook;
    public $instagram;
    public $tiktok;
    public $owner_name;
    public $owner_email;
    public $average_rating;
    public $review_count;
    public $amenities;
    public $experiences;
    public $services;


    public function getBusinessesProperty()
    {
        return TourismBusiness::when($this->search, function ($query) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('business_type', 'like', '%'.$this->search.'%')
                ->orWhere('city', 'like', '%'.$this->search.'%')
                ->orWhere('price_range', 'like', '%'.$this->search.'%')
                ->orWhere('average_rating', 'like', '%'.$this->search.'%');
            });
        })->latest()->paginate(20);
    }

    public function createBusiness()
    {

        $amenitiesArray = null;
        $servicesArray = null;
        $experiencesArray = null;

        // handle arrays
        if($this->amenities){
            $amenitiesArray = explode(',', $this->amenities);
        }

        if($this->services){
            $servicesArray = explode(',', $this->services);
        }

        if($this->experiences){
            $experiencesArray = explode(',', $this->experiences);
        }

        // Default Values for SQlite
        if($this->review_count === null){
            $this->review_count = 0;
        }

        if($this->average_rating === null){
            $this->average_rating = 0;
        }

        $validated = $this->validate([
            'name' => "required|string",
            'description' => "nullable|string",
            'business_type' => "required|string",
            'country' => "required|string",
            'city' => "required|string",
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048|required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Generate slug from business name
        $this->slug = Str::slug($this->name);

        // Handle cover image upload if exists
        $coverImagePath = $this->coverImage->store('businesses/covers', 'public');

        // Handle multiple images upload if exists
        $imagePaths = [];
        if ($this->images) {
            foreach ($this->images as $image) {
                $imagePaths[] = $image->store('businesses/images', 'public');
            }
        }

        $business = TourismBusiness::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'business_type' => $this->business_type,
            'category' => $this->category,
            'is_featured' => $this->is_featured,
            'status' => $this->status,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'whatsapp' => $this->whatsapp,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'video_url' => $this->video_url,
            'price_range' => $this->price_range,
            'currency' => $this->currency,
            'accepts_credit_card' => $this->accepts_credit_card,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'tiktok' => $this->tiktok,
            'owner_name' => $this->owner_name,
            'owner_email' => $this->owner_email,
            'average_rating' => $this->average_rating,
            'review_count' => $this->review_count,
            'cover_image' => $coverImagePath,
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : null, // Store as JSON array
            'services' => $servicesArray,
            'amenities' => $amenitiesArray,
            'experience' => $experiencesArray,
        ]);

        $this->reset();
        $this->dispatch('business-created');
    }

    public function edit($id)
    {
        $this->reset(['coverImage', 'images', 'imagesToRemove']);
        $this->id = $id;
        $business = TourismBusiness::findOrFail($id);

        $this->id = $business->id;
        $this->editedName = $business->name;
        $this->originalName = $business->name;
        $this->description = $business->description;
        $this->business_type = $business->business_type;
        $this->category = $business->category ?? [];
        $this->is_featured = $business->is_featured;
        $this->status = $business->status;
        $this->phone = $business->phone;
        $this->email = $business->email;
        $this->website = $business->website;
        $this->whatsapp = $business->whatsapp;
        $this->country = $business->country;
        $this->city = $business->city;
        $this->address = $business->address;
        $this->latitude = $business->latitude;
        $this->longitude = $business->longitude;
        $this->video_url = $business->video_url;
        $this->price_range = $business->price_range;
        $this->currency = $business->currency;
        $this->accepts_credit_card = $business->accepts_credit_card;
        $this->facebook = $business->facebook;
        $this->instagram = $business->instagram;
        $this->tiktok = $business->tiktok;
        $this->owner_name = $business->owner_name;
        $this->owner_email = $business->owner_email;
        $this->average_rating = $business->average_rating;
        $this->review_count = $business->review_count;
        $this->amenities = $business->amenities;
        $this->services = $business->services;
        $this->experiences = $business->experience;

        
        // Set current images
        $this->currentCoverImage = $business->cover_image;
        $this->currentImages = $business->images ? json_decode($business->images) : [];
    }

    public function removeCoverImage()
    {
        $this->imagesToRemove[] = $this->currentCoverImage;
        $this->currentCoverImage = null;
        $this->coverImage = null;
    }

    public function removeExistingImage($index)
    {
        if (isset($this->currentImages[$index])) {
            // Track image for deletion
            $this->imagesToRemove[] = $this->currentImages[$index];
            // Remove from current images
            unset($this->currentImages[$index]);
            $this->currentImages = array_values($this->currentImages);
        }
    }

    public function removeImage($index)
    {
        // Remove from current images array
        if (isset($this->currentImages[$index])) {
            $this->imagesToRemove[] = $this->currentImages[$index];
            unset($this->currentImages[$index]);
            $this->currentImages = array_values($this->currentImages); // Reindex array
        }
        // Remove from new images array
        elseif (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images); // Reindex array
        }
    }

    public function updateBusiness($id)
    {
        $amenitiesArray = null;
        $servicesArray = null;
        $experiencesArray = null;

        // handle strings , check if they ar not arrays
        if($this->amenities){
            $amenitiesArray = is_array($this->amenities) ? $this->amenities : explode(',', $this->amenities);
        }

        if($this->services){
            $servicesArray = is_array($this->services) ? $this->services : explode(',', $this->services);
        }

        if($this->experiences){
            $experiencesArray = is_array($this->experiences) ? $this->experiences : explode(',', $this->experiences);
        }

        // Default Values for SQlite
        if($this->review_count === null){
            $this->review_count = 0;
        }

        if($this->average_rating === null){
            $this->average_rating = 0;
        }

        $validated = $this->validate([
            'editedName' => 'required|string',
            'description' => 'nullable|string',
            'business_type' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $business = TourismBusiness::findOrFail($id);
        $slug = Str::slug($this->editedName);

        // Handle cover image upload if exists
        $coverImagePath = $this->currentCoverImage;
        if ($this->coverImage) {
            // Delete old cover image if exists
            if ($this->currentCoverImage) {
                Storage::disk('public')->delete($this->currentCoverImage);
            }
            $coverImagePath = $this->coverImage->store('businesses/covers', 'public');
        } elseif ($this->currentCoverImage === null) {
            // Cover image was removed
            $coverImagePath = null;
        }

        // Handle multiple images upload
        $imagePaths = $this->currentImages;
        if ($this->images) {
            foreach ($this->images as $image) {
                $imagePaths[] = $image->store('businesses/images', 'public');
            }
        }

        // Delete images marked for removal
        foreach ($this->imagesToRemove as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        $business->update([
            'name' => $this->editedName,
            'slug' => $slug,
            'description' => $this->description,
            'business_type' => $this->business_type,
            'category' => $this->category,
            'is_featured' => $this->is_featured,
            'status' => $this->status,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'whatsapp' => $this->whatsapp,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'video_url' => $this->video_url,
            'price_range' => $this->price_range,
            'currency' => $this->currency,
            'accepts_credit_card' => $this->accepts_credit_card,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'tiktok' => $this->tiktok,
            'owner_name' => $this->owner_name,
            'owner_email' => $this->owner_email,
            'average_rating' => $this->average_rating,
            'review_count' => $this->review_count,
            'cover_image' => $coverImagePath,
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : null,
            'services' => $servicesArray,
            'amenities' => $amenitiesArray,
            'experience' => $experiencesArray,
        ]);

        $this->originalName = $this->editedName;
        $this->dispatch('business-updated');
        $this->dispatch('close-modal', name: 'update-business');
    }

    public function deleteBusiness($id)
    {
        $business = TourismBusiness::findOrFail($id);
        $business->delete();
        $this->dispatch('business-deleted', $id);
    }

    public function resetForm()
    {
        $this->reset();
    }

}; ?>

<div >

    {{-- Create business modal --}}
<flux:modal name="create-business" class="md:w-[800px]">
    <form wire:submit.ignore="createBusiness">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add New Tourism Business</flux:heading>
                <flux:text class="mt-2">Register a new tourism business</flux:text>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Basic Info --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Basic Information</flux:heading>
                    <flux:input wire:model="name" wire:model.live="slug" label="Business Name" placeholder="Slug will be generated automatically" />
                    <flux:textarea wire:model="description" label="Description" />
                    <flux:input wire:model="business_type" label="Business Type" placeholder="e.g., Lodge, Travel Agency" />
                    <flux:checkbox wire:model="is_featured" label="Featured Business" />
                    <flux:select wire:model="status" label="Status">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                    </flux:select>
                </div>
                
                {{-- Contact Info --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Contact Information</flux:heading>
                    <flux:input wire:model="phone" label="Phone Number" />
                    <flux:input wire:model="email" label="Email" type="email" />
                    <flux:input wire:model="website" label="Website" />
                    <flux:input wire:model="whatsapp" label="WhatsApp" />
                </div>
                
                {{-- Location --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Location</flux:heading>
                    <flux:input wire:model="country" label="Country" />
                    <flux:input wire:model="city" label="City" />
                    <flux:input wire:model="address" label="Address" />
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input wire:model="latitude" label="Latitude" type="number" step="0.000001" />
                        <flux:input wire:model="longitude" label="Longitude" type="number" step="0.000001" />
                    </div>
                </div>
                
                {{-- Amenities --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Amenities</flux:heading>
                    <flux:textarea placeholder="items 1, item 2, item 3" wire:model="amenities" />
                    {{-- <div class="grid grid-cols-2 gap-4">
                        <flux:checkbox wire:model="parking" label="Parking" />
                        <flux:checkbox wire:model="pool" label="Pool" />
                        <flux:checkbox wire:model="bar" label="Bar" />
                        <flux:checkbox wire:model="restaurant" label="Restaurant" />
                        <flux:checkbox wire:model="pet_friendly" label="Pet Friendly" />
                        <flux:checkbox wire:model="accepts_credit_card" label="Accepts Credit Cards" />
                    </div> --}}

                    <flux:heading size="sm">Services</flux:heading>
                    <flux:textarea placeholder="items 1, item 2, item 3" wire:model="services" />

                    <flux:heading size="sm">Experiences</flux:heading>
                    <flux:textarea placeholder="items 1, item 2, item 3" wire:model="experiences" />

                    <div class="grid grid-cols-2 gap-4">
                        <flux:input wire:model="price_range" placeholder="R0 - R1000" label="Price Range" />
                        <flux:input step="0.0" wire:model="average_rating" type="number"  label="Average Rating" />
                        <flux:input wire:model="review_count" type="number" label="Review Count" />
                    </div>
                </div>

                {{-- Cover Image --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Cover Image</flux:heading>
                    <div class="space-y-2">
                        <div x-data="{ isUploading: false, progress: 0 }" 
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image (Max 2MB)</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="pt-1 text-sm text-gray-600">Click to upload cover image</p>
                                    </div>
                                    <input type="file" class="opacity-0" wire:model="coverImage" accept="image/*" />
                                </label>
                            </div>
                            <div x-show="isUploading" class="mt-2">
                                <progress max="100" x-bind:value="progress" class="w-full"></progress>
                            </div>
                            @error('coverImage') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Cover Image Preview -->
                        <div wire:loading.remove wire:target="coverImage">
                            @if ($coverImage)
                                <div class="mt-2">
                                    <span class="block text-sm font-medium text-gray-700 mb-1">Preview:</span>
                                    <img src="{{ $coverImage->temporaryUrl() }}" class="h-32 w-full object-cover rounded-md">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Additional Images --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Additional Images</flux:heading>
                    <div class="space-y-2">
                        <div x-data="{ isUploading: false, progress: 0 }" 
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Images (Max 2MB each)</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="pt-1 text-sm text-gray-600">Click to upload multiple images</p>
                                    </div>
                                    <input type="file" class="opacity-0" wire:model="images" multiple accept="image/*" />
                                </label>
                            </div>
                            <div x-show="isUploading" class="mt-2">
                                <progress max="100" x-bind:value="progress" class="w-full"></progress>
                            </div>
                            @error('images') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            @error('images.*') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Additional Images Preview -->
                        <div wire:loading.remove wire:target="images">
                            @if ($images)
                                <div class="mt-2">
                                    <span class="block text-sm font-medium text-gray-700 mb-1">Preview:</span>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($images as $index => $image)
                                            <div class="relative">
                                                <img src="{{ $image->temporaryUrl() }}" class="h-24 w-full object-cover rounded-md">
                                                <button type="button" wire:click="removeImage({{ $index }})" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center -mt-1 -mr-1">
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex">
                <flux:spacer />
 
                <div class="flex items-center gap-4">
                    <x-action-message class="me-3" on="business-created">
                        {{ __('Saved.') }}
                    </x-action-message>

                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full cursor-pointer">{{ __('Save') }}</flux:button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</flux:modal>

{{-- Update business modal --}}
<flux:modal name="update-business" class="md:w-[800px]">
    <form wire:submit.ignore="updateBusiness({{ $id }})">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update Business</flux:heading>
                <flux:text class="mt-2">{{ $this->originalName }}</flux:text>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Basic Info --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Basic Information</flux:heading>
                    <flux:input wire:model="editedName" wire:model.live="slug" label="Business Name" placeholder="Slug will be generated automatically" />
                    <flux:textarea wire:model="description" label="Description" />
                    <flux:input wire:model="business_type" label="Business Type" placeholder="e.g., Lodge, Travel Agency" />
                    <flux:checkbox wire:model="is_featured" label="Featured Business" />
                    <flux:select wire:model="status" label="Status">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                    </flux:select>
                </div>
                
                {{-- Contact Info --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Contact Information</flux:heading>
                    <flux:input wire:model="phone" label="Phone Number" />
                    <flux:input wire:model="email" label="Email" type="email" />
                    <flux:input wire:model="website" label="Website" />
                    <flux:input wire:model="whatsapp" label="WhatsApp" />
                </div>
                
                {{-- Location --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Location</flux:heading>
                    <flux:input wire:model="country" label="Country" />
                    <flux:input wire:model="city" label="City" />
                    <flux:input wire:model="address" label="Address" />
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input wire:model="latitude" label="Latitude" type="number" step="0.000001" />
                        <flux:input wire:model="longitude" label="Longitude" type="number" step="0.000001" />
                    </div>
                </div>
                
                {{-- Amenities --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Amenities</flux:heading>
                    <flux:textarea placeholder="items 1, item 2, item 3" wire:model="amenities" />
                    {{-- <div class="grid grid-cols-2 gap-4">
                        <flux:checkbox wire:model="parking" label="Parking" />
                        <flux:checkbox wire:model="pool" label="Pool" />
                        <flux:checkbox wire:model="bar" label="Bar" />
                        <flux:checkbox wire:model="restaurant" label="Restaurant" />
                        <flux:checkbox wire:model="pet_friendly" label="Pet Friendly" />
                        <flux:checkbox wire:model="accepts_credit_card" label="Accepts Credit Cards" />
                    </div> --}}

                    <flux:heading size="sm">Services</flux:heading>
                    <flux:textarea placeholder="items 1, item 2, item 3" wire:model="services" />

                    <flux:heading size="sm">Experiences</flux:heading>
                    <flux:textarea placeholder="items 1, item 2, item 3" wire:model="experiences" />

                    <div class="grid grid-cols-2 gap-4">
                        <flux:input wire:model="price_range" placeholder="R0 - R1000" label="Price Range" />
                        <flux:input step="0.0" wire:model="average_rating" type="number"  label="Average Rating" />
                        <flux:input wire:model="review_count" type="number" label="Review Count" />
                    </div>
                </div>

                {{-- Cover Image --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Cover Image</flux:heading>
                    <div class="space-y-2">
                        <div x-data="{ isUploading: false, progress: 0 }" 
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image (Max 2MB)</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="pt-1 text-sm text-gray-600">Click to upload cover image</p>
                                    </div>
                                    <input type="file" class="opacity-0" wire:model="coverImage" accept="image/*" />
                                </label>
                            </div>
                            <div x-show="isUploading" class="mt-2">
                                <progress max="100" x-bind:value="progress" class="w-full"></progress>
                            </div>
                            @error('coverImage') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Cover Image Preview -->
                        <div wire:loading.remove wire:target="coverImage">
                            @if ($coverImage)
                                <div class="mt-2">
                                    <span class="block text-sm font-medium text-gray-700 mb-1">New Cover Image:</span>
                                    <img src="{{ $coverImage->temporaryUrl() }}" class="h-32 w-full object-cover rounded-md">
                                    <button type="button" wire:click="$set('coverImage', null)" 
                                            class="mt-2 text-sm text-red-600 hover:text-red-800 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Remove New Image
                                    </button>
                                </div>
                            @endif
                            
                            @if ($currentCoverImage)
                                <div class="mt-2">
                                    <span class="block text-sm font-medium text-gray-700 mb-1">Current Cover Image:</span>
                                    <img src="{{ asset('storage/' . $currentCoverImage) }}" class="h-32 w-full object-cover rounded-md">
                                    <button type="button" wire:click="removeCoverImage" 
                                            class="mt-2 text-sm text-red-600 hover:text-red-800 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Remove Current Image
                                    </button>
                                </div>
                            @endif
                            
                            @if (!$coverImage && !$currentCoverImage)
                                <div class="mt-2 text-sm text-gray-500 italic">
                                    No cover image selected
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Additional Images --}}
                <div class="space-y-4">
                    <flux:heading size="sm">Additional Images</flux:heading>
                    <div class="space-y-2">
                        <div x-data="{ isUploading: false, progress: 0 }" 
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Images (Max 2MB each)</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="pt-1 text-sm text-gray-600">Click to upload multiple images</p>
                                    </div>
                                    <input type="file" class="opacity-0" wire:model="images" multiple accept="image/*" />
                                </label>
                            </div>
                            <div x-show="isUploading" class="mt-2">
                                <progress max="100" x-bind:value="progress" class="w-full"></progress>
                            </div>
                            @error('images') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            @error('images.*') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Additional Images Preview -->
                        <div wire:loading.remove wire:target="images">
                            @if ($images && count($images) > 0)
                                <div class="mt-2">
                                    <span class="block text-sm font-medium text-gray-700 mb-1">New Images:</span>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($images as $index => $image)
                                            <div class="relative group">
                                                <img src="{{ $image->temporaryUrl() }}" class="h-24 w-full object-cover rounded-md">
                                                <button type="button" wire:click="removeImage({{ $index }})" 
                                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center -mt-1 -mr-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            @if ($currentImages && count($currentImages) > 0)
                                <div class="mt-2">
                                    <span class="block text-sm font-medium text-gray-700 mb-1">Current Images:</span>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($currentImages as $index => $image)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $image) }}" class="h-24 w-full object-cover rounded-md">
                                                <button type="button" wire:click="removeExistingImage({{ $index }})" 
                                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center -mt-1 -mr-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            @if ((!$images || count($images) === 0) && (!$currentImages || count($currentImages) === 0))
                                <div class="mt-2 text-sm text-gray-500 italic">
                                    No additional images uploaded
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex">
                <flux:spacer />
                <div class="flex items-center gap-4">
                    <x-action-message class="me-3" on="business-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</flux:modal>


    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Golf Tourism Listing') }}</flux:heading>
                <flux:breadcrumbs class="mb-4 mt-2">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}">Home</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>Listing</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </div>
        <flux:separator variant="subtle" />
    </div>
    <div>

        <div class="flex justify-between items-center mb-5">
            <flux:modal.trigger name="create-business">
                <flux:button wire:click="resetForm()" class="cursor-pointer">Add New Business</flux:button>
            </flux:modal.trigger>

            <div class="w-[200px]">
                <flux:input
                    wire:model.live="search"
                    type="text"
                    required
                    placeholder="Search"
                    autocomplete="current-password"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class=" border-b border-gray-200 dark:border-gray-600">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Type</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">City</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Price Range</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Tier</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Rating</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Payment</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Amenities</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Services</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Experience</th>
                        {{-- <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Created</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Updated</th> --}}
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($this->businesses as $business)
                        <tr class="border-b border-gray-300 dark:hover:bg-gray-600 hover:bg-gray-100 dark:border-gray-600">
                            <td class="px-5 py-2 text-sm whitespace-nowrap">{{ $business->name }}</td>
                            <td class="px-5 py-2 text-sm whitespace-nowrap">{{ $business->business_type }}</td>
                            <td class="px-5 py-2 text-sm whitespace-nowrap">{{ $business->city }}</td>
                            <td class="px-5 py-2 text-sm whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $business->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $business->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $business->status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($business->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-2 text-sm whitespace-nowrap">{{ $business->price_range }}</td>
                            <td class="px-5 py-2 text-sm whitespace-nowrap">
                                @if($business->is_featured)
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Featured</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Standard</span>
                                @endif
                            </td>
                            {{-- <td class="px-5 py-2 text-sm">
                                @if($business->category)
                                    {{ implode(', ', json_decode($business->category)) }}
                                @endif
                            </td> --}}
                            <td class="px-5 py-2 text-sm whitespace-nowrap">{{ $business->average_rating }} ★ ({{ $business->review_count }})</td>
                            <td class="px-5 py-2 text-sm whitespace-nowrap">
                                @if($business->accepts_credit_card)
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Cards</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Cash Only</span>
                                @endif
                            </td>

                            

                            <td class="px-5 py-2 text-sm whitespace-nowrap">
                                @if ($business->amenities)
                                    @foreach ($business->amenities as $amenity)
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $amenity }}</span>
                                    @endforeach
                                @endif
                            </td>

                            <td class="px-5 py-2 text-sm whitespace-nowrap">
                                @if ($business->services)
                                    @foreach ($business->services as $service)
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $service }}</span>
                                    @endforeach
                                @endif
                            </td>

                            <td class="px-5 py-2 text-sm whitespace-nowrap">
                                @if ($business->experience)
                                    @foreach ($business->experience as $experience)
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $experience }}</span>
                                    @endforeach
                                @endif
                            </td>
                            

                            {{-- <td class="px-5 py-2 text-sm whitespace-nowrap">{{ $business->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-5 py-2 text-sm whitespace-nowrap">{{ $business->updated_at->format('M d, Y H:i') }}</td> --}}
                                
                            <td class="px-5 py-2 text-sm whitespace-nowrap flex gap-2 place-content-center">
                                <flux:modal.trigger wire:click="edit({{ $business->id }})" name="update-business">
                                    <flux:icon.pencil-square class="size-5 cursor-pointer" color="green" />
                                </flux:modal.trigger>
                            
                                <flux:icon.trash class="size-5 cursor-pointer" color="red" wire:click="deleteBusiness({{ $business->id }})" wire:confirm="Are you sure you want to delete?" />
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $this->businesses->links() }}
        </div>

    </div>
</div>