<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $destination = Destination::first();

        Event::create([
            'destination_id' => $destination->id,
            'title' => 'جشن گلاب‌گیری محل',
            'description' => 'مراسم سنتی گلاب‌گیری با حضور هنرمندان محلی',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(12),
            'location' => 'اصفهان',
            'address' => 'میدان نقش جهان',
            'capacity' => 100,
            'remaining_capacity' => 12,
            'image_url' => 'https://example.com/images/golabgiri.jpg',
            'status' => 'upcoming',
            'price' => 50000,
            'organizer' => 'انجمن صنایع دستی اصفهان',
            'contact_info' => '09123456789',
        ]);

        // Add more events as needed
    }
}