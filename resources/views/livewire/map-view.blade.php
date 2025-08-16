<?php
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\TourismBusiness;

new
#[Layout('components.layouts.welcome')]
class extends Component {
    
    public $mapLocations = [];

    public function mount(){
        $this->mapLocations = TourismBusiness::latest()->get();
    }

}; ?>

    <div class="h-full relative" x-data="mapComponent(@js($this->mapLocations))" x-init="initMap()">
        <div id="map" class="h-[400px] md:h-screen w-full rounded-xl md:sticky md:top-0"></div> <!-- Fixed height -->
    </div>

    <script>
            
            // function mapComponent(locations) {
            //     return {
            //         map: null,
            //         markers: [],
            //         initMap() {
            //             this.map = L.map('map').setView([-28.4796, 24.6981], 7);

            //             L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //                 attribution: '&copy; OpenStreetMap contributors'
            //             }).addTo(this.map);

            //             locations.forEach(loc => {
            //                 const marker = L.marker([loc.latitude, loc.longitude]).addTo(this.map);

            //                 marker.bindTooltip(`
            //                     <div class="rounded" style="text-align:center; width:300px; height:200px;overflow:hidden;">
            //                         <strong>${loc.name}</strong><br/>
            //                         <img class="rounded" src="${loc.cover_image}" alt="${loc.name}" style="width:100%; height:auto; object-fit:cover; margin-top:5px;" />
            //                     </div>
            //                 `, {
            //                     direction: 'top',
            //                     sticky: true,
            //                     opacity: 1,
            //                     permanent: false
            //                 });

            //                 marker.on('click', function () {
            //                     window.location.href = `/listing/${loc.slug}`; // Replace with your actual route
            //                 });
            //             });
            //         }
            //     }
            // };

            function mapComponent(locations) {
                return {
                    map: null,
                    markers: [],
                    initMap() {
                        this.map = L.map('map').setView([-28.4796, 24.6981], 6);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(this.map);

                        locations.forEach(loc => {
                            // Define custom icon from Laravel storage
                            const customIcon = L.icon({
                                iconUrl: `/storage/marker.png`, // Make sure storage is linked: php artisan storage:link
                                iconSize: [20],  // size of the icon
                                iconAnchor: [20, 40], // point of the icon which corresponds to marker's location
                                popupAnchor: [0, -40] // point from which popup should open relative to the iconAnchor
                            });

                            // Use custom marker
                            const marker = L.marker([loc.latitude, loc.longitude], { icon: customIcon }).addTo(this.map);

                            marker.bindTooltip(`
                                <div class="rounded" style="text-align:center; width:300px; height:200px;overflow:hidden;">
                                    <strong>${loc.name}</strong><br/>
                                    <img class="rounded" src="${loc.cover_image}" alt="${loc.name}" style="width:100%; height:auto; object-fit:cover; margin-top:5px;" />
                                </div>
                            `, {
                                direction: 'top',
                                sticky: true,
                                opacity: 1,
                                permanent: false
                            });

                            marker.on('click', function () {
                                window.location.href = `/listing/${loc.slug}`;
                            });
                        });
                    }
                }
            };

        </script>

