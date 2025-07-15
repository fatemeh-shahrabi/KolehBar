<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Destination;
use App\Models\Event;

class Welcome extends Component
{
    public $featuredDestinations;
    public $ongoingEvents;

    public function mount()
    {
        $this->featuredDestinations = Destination::where('is_featured', true)
            ->with(['events' => fn($q) => $q->where('status', 'ongoing')->limit(3)])
            ->limit(4)
            ->get();

        $this->ongoingEvents = Event::where('status', 'ongoing')
            ->with('destination')
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}