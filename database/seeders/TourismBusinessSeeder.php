<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourismBusiness;
use Faker\Factory as Faker;

class TourismBusinessSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // South African cities array
        $southAfricanCities = [
            'Johannesburg', 'Cape Town', 'Durban', 'Pretoria', 'Port Elizabeth',
            'Bloemfontein', 'East London', 'Pietermaritzburg', 'Nelspruit', 'Polokwane',
            'Rustenburg', 'Kimberley', 'George', 'Knysna', 'Mossel Bay',
            'Stellenbosch', 'Franschhoek', 'Hermanus', 'Plettenberg Bay', 'Oudtshoorn'
        ];

        // Business types
        $businessTypes = [
            'Lodge', 'Hotel', 'Guest House', 'Bed & Breakfast', 'Safari Lodge',
            'Game Reserve', 'Travel Agency', 'Tour Operator', 'Adventure Company',
            'Restaurant', 'Wine Estate', 'Spa', 'Car Rental', 'Cultural Village',
            'Museum', 'Art Gallery', 'Shopping Center'
        ];

        // Categories
        $categories = [
            ['Adventure', 'Hiking'], 
            ['Luxury', 'Spa'], 
            ['Family', 'Budget'],
            ['Romantic', 'Honeymoon'],
            ['Business', 'Conference'],
            ['Wildlife', 'Safari'],
            ['Beach', 'Coastal'],
            ['Cultural', 'Historical'],
            ['Food', 'Wine'],
            ['Shopping', 'Entertainment']
        ];

        // Services
        $services = [
            ['Free WiFi', 'Swimming Pool', 'Air Conditioning'],
            ['Guided Tours', 'Airport Shuttle', 'Room Service'],
            ['Spa Treatments', 'Fitness Center', 'Conference Facilities'],
            ['Childcare', 'Pet Friendly', 'Laundry Service'],
            ['Diving', 'Fishing', 'Boat Cruises'],
            ['Wine Tasting', 'Cooking Classes', 'Restaurant'],
            ['Game Drives', 'Bush Walks', 'Bird Watching']
        ];

        // Operating hours
        $operatingHours = [
            'Monday' => '08:00-22:00',
            'Tuesday' => '08:00-22:00',
            'Wednesday' => '08:00-22:00',
            'Thursday' => '08:00-22:00',
            'Friday' => '08:00-23:00',
            'Saturday' => '09:00-23:00',
            'Sunday' => '09:00-21:00'
        ];

        // Price ranges
        $priceRanges = [
            'R500 - R1000', 'R1000 - R2000', 'R2000 - R5000', 
            'R5000 - R10000', 'R100 - R500', 'R50 - R200'
        ];

        // Dummy image URLs (using Unsplash with South Africa theme)
        $imageUrls = [
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
            'https://images.unsplash.com/photo-1503917988258-f87a78e3c995?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
            'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
            'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
            'https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
            'https://images.unsplash.com/photo-1505884065216-0661d68e5c47?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80'
        ];

        // Real South African tourism businesses names
        $businessNames = [
            // Lodges & Hotels
            'The Saxon Hotel, Villas & Spa',
            'One&Only Cape Town',
            'The Oyster Box Hotel',
            'Shamwari Game Reserve',
            'Singita Lebombo Lodge',
            'Royal Malewane',
            'Tintswalo Atlantic',
            'The Silo Hotel',
            'Bushmans Kloof Wilderness Reserve',
            'Grootbos Private Nature Reserve',
            
            // Guest Houses & B&Bs
            'Cape Heritage Hotel',
            'The Last Word Franschhoek',
            'Houghton View Guesthouse',
            'Coral Tree Cottages',
            'Anew Hotel Green Court',
            'Protea Hotel by Marriott Durban Umhlanga',
            'The Winston Hotel',
            'The Capital 15 on Orange',
            'The Peech Hotel',
            'Villa Sterne Boutique Hotel',
            
            // Safari & Game Lodges
            'Sabi Sabi Private Game Reserve',
            'Phinda Private Game Reserve',
            'Madikwe Safari Lodge',
            'Kapama Private Game Reserve',
            'Thornybush Game Lodge',
            'Tswalu Kalahari',
            'Londolozi Game Reserve',
            'Ulusaba Private Game Reserve',
            'MalaMala Game Reserve',
            'Ant\'s Nest & Ant\'s Hill',
            
            // Travel & Tour Operators
            'Thompsons Africa',
            'Springbok Atlas',
            'Tours 4 Fun South Africa',
            'Shamwari Private Game Reserve Tours',
            'Cape Town Travel',
            'Durban Tourism',
            'Johannesburg City Tours',
            'Garden Route Tours',
            'Kruger National Park Safaris',
            'Winelands Tours',
            
            // Adventure Companies
            'Abseil Africa',
            'Face Adrenalin',
            'Bungee Jumping at Bloukrans Bridge',
            'Shark Cage Diving Gansbaai',
            'Cape Canopy Tour',
            'SA Forest Adventures',
            'White Water Rafting',
            'Sandboarding Cape Town',
            'Paragliding Cape Town',
            'Kitesurfing Lessons Durban',
            
            // Restaurants & Wine Estates
            'La Colombe',
            'The Test Kitchen',
            'The Pot Luck Club',
            'Jordan Wine Estate',
            'Boschendal Wine Estate',
            'Spier Wine Farm',
            'Delaire Graff Estate',
            'Babylonstoren',
            'The Tasting Room at Le Quartier Français',
            'Fyndraai Restaurant',
            
            // Spas & Wellness
            'The Twelve Apostles Spa',
            'Saxon Spa',
            'One&Only Spa',
            'The Hydro at Steenberg',
            'Bushmans Kloof Spa',
            'The Cellars-Hohenort Spa',
            'The Spa at Mount Nelson',
            'The Sanctuary Spa',
            'Angsana Spa',
            'The Spa at The Oyster Box',
            
            // Cultural & Historical
            'Apartheid Museum',
            'Robben Island Museum',
            'District Six Museum',
            'Voortrekker Monument',
            'Cradle of Humankind',
            'Gold Reef City',
            'The Castle of Good Hope',
            'Nelson Mandela Capture Site',
            'Freedom Park',
            'Iziko South African Museum',
            
            // Shopping & Entertainment
            'V&A Waterfront',
            'Sandton City',
            'Gateway Theatre of Shopping',
            'Cavendish Square',
            'Menlyn Park Shopping Centre',
            'Montecasino',
            'Sun City Resort',
            'Gold Reef City Casino',
            'GrandWest Casino',
            'Emperors Palace'
        ];

        for ($i = 0; $i < 100; $i++) {
            $randomImages = $faker->randomElements($imageUrls, $faker->numberBetween(1, 5));
            $randomCategory = $categories[$faker->numberBetween(0, count($categories) - 1)];
            $randomServices = $services[$faker->numberBetween(0, count($services) - 1)];

            TourismBusiness::create([
                // Basic Info
                'name' => $businessNames[$i],
                'slug' => \Illuminate\Support\Str::slug($businessNames[$i]),
                'description' => $faker->paragraphs($faker->numberBetween(2, 5), true),
                'business_type' => $businessTypes[$faker->numberBetween(0, count($businessTypes) - 1)],
                'category' => $randomCategory,
                'is_featured' => $faker->boolean(30),
                'status' => $faker->randomElement(['pending', 'active', 'active', 'active', 'suspended']),
                'date_registered' => $faker->dateTimeBetween('-5 years', 'now'),

                // Contact
                'phone' => '+27 ' . $faker->numerify('## ### ####'),
                'email' => $faker->safeEmail,
                'website' => 'https://www.' . \Illuminate\Support\Str::slug($businessNames[$i]) . '.co.za',
                'whatsapp' => '+27 ' . $faker->numerify('## ### ####'),

                // Location
                'country' => 'South Africa',
                'city' => $southAfricanCities[$faker->numberBetween(0, count($southAfricanCities) - 1)],
                'address' => $faker->streetAddress,
                'latitude' => $faker->latitude(-22.1266, -34.834),
                'longitude' => $faker->longitude(16.344, 32.895),

                // Media
                'images' => $randomImages,
                'video_url' => $faker->boolean(20) ? 'https://www.youtube.com/watch?v=' . $faker->regexify('[A-Za-z0-9]{11}') : null,

                // Services & Amenities
                'services' => $randomServices,
                'parking' => $faker->boolean(80),
                'pool' => $faker->boolean(60),
                'bar' => $faker->boolean(70),
                'restaurant' => $faker->boolean(65),
                'pet_friendly' => $faker->boolean(40),

                // Operating Hours
                'operating_hours' => $operatingHours,

                // Pricing
                'price_range' => $priceRanges[$faker->numberBetween(0, count($priceRanges) - 1)],
                'currency' => 'ZAR',
                'accepts_credit_card' => $faker->boolean(90),

                // Ratings
                'average_rating' => $faker->randomFloat(1, 3, 5),
                'review_count' => $faker->numberBetween(5, 500),

                // Social Media
                'facebook' => $faker->boolean(70) ? 'https://facebook.com/' . \Illuminate\Support\Str::slug($businessNames[$i]) : null,
                'instagram' => $faker->boolean(70) ? 'https://instagram.com/' . \Illuminate\Support\Str::slug($businessNames[$i]) : null,
                'tiktok' => $faker->boolean(30) ? 'https://tiktok.com/@' . \Illuminate\Support\Str::slug($businessNames[$i]) : null,

                // Owner Info
                'owner_name' => $faker->name,
                'owner_email' => $faker->safeEmail,

                'created_at' => $faker->dateTimeBetween('-5 years', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now')
            ]);
        }
    }
}