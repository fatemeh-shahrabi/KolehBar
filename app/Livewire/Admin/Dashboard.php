<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Destination;
use App\Models\Event;

class Dashboard extends Component
{
    public $userCount;
    public $destinationCount;
    public $eventCount;
    public $ongoingEventsCount;

    public function mount()
    {
        $this->userCount = User::count();
        $this->destinationCount = Destination::count();
        $this->eventCount = Event::count();
        $this->ongoingEventsCount = Event::where('status', 'ongoing')->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.admin', ['title' => 'داشبورد مدیریت']);
    }
}