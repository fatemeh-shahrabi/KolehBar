<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationsTableSeeder extends Seeder
{
    public function run()
    {
        Destination::create([
            'name' => 'مسجد جامع اصفهان',
            'description' => 'مسجد جامع اصفهان از مهم‌ترین و قدیمی‌ترین ابنیه مذهبی ایران است.',
            'location' => 'اصفهان',
            'province' => 'اصفهان',
            'city' => 'اصفهان',
            'address' => 'میدان قیام، خیابان علامه مجلسی',
            'best_time_to_visit' => '۹ صبح تا ۱۲ ظهر',
            'rating' => 4.8,
            'image_url' => 'https://example.com/images/jameh-mosque.jpg',
            'category' => 'تاریخی',
            'tags' => json_encode(['مسجد', 'تاریخی', 'گردشگری']),
            'latitude' => 32.6706,
            'longitude' => 51.6873,
            'is_featured' => true,
        ]);

        // Add more destinations as needed
    }
}