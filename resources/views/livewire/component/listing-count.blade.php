<?php

use Livewire\Volt\Component;
use App\Models\TourismBusiness;

new class extends Component {
    public $listingCount;

    public function mount()
    {
        $this->listingCount = TourismBusiness::count();
    }
}; ?>

<span>({{ $listingCount }})</span>
