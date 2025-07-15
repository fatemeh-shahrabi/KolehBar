<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Models\Destination;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class Events extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $statusFilter = '';
    
    // For create/edit
    public $showModal = false;
    public $modalTitle = '';
    public $eventId = null;
    public $title = '';
    public $description = '';
    public $destination_id = '';
    public $start_date = '';
    public $end_date = '';
    public $address = '';
    public $capacity = 50;
    public $price = 0;
    public $organizer = '';
    public $contact_info = '';
    public $image;
    public $imageUrl;
    public $status = 'upcoming';

// app/Livewire/Admin/Events.php

protected $rules = [
    'title' => 'required|min:3',
    'description' => 'required|min:10',
    'destination_id' => 'required|exists:destinations,id',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after:start_date',
    'capacity' => 'required|numeric|min:1',
    'price' => 'numeric|min:0',
    'organizer' => 'required', // Add this
    'contact_info' => 'required', // Add this
    'image' => 'nullable|image|max:2048',
];

public function saveEvent()
{
    $this->validate();

    $data = [
        'title' => $this->title,
        'description' => $this->description,
        'destination_id' => $this->destination_id,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
        'location' => $this->address, // Add this to match your schema
        'address' => $this->address,
        'capacity' => $this->capacity,
        'remaining_capacity' => $this->capacity,
        'price' => $this->price,
        'organizer' => $this->organizer,
        'contact_info' => $this->contact_info,
        'status' => $this->status,
    ];

    try {
        if ($this->image) {
            $path = $this->image->store('events', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        if ($this->eventId) {
            Event::find($this->eventId)->update($data);
            session()->flash('success', 'رویداد با موفقیت ویرایش شد');
        } else {
            Event::create($data);
            session()->flash('success', 'رویداد جدید با موفقیت ایجاد شد');
        }

        $this->showModal = false;
        $this->reset(); // Reset all properties
    } catch (\Exception $e) {
        session()->flash('error', 'خطا در ذخیره رویداد: ' . $e->getMessage());
    }
}

    public function openModal($id = null)
    {
        $this->reset();
        
        if ($id) {
            $event = Event::findOrFail($id);
            $this->eventId = $id;
            $this->title = $event->title;
            $this->description = $event->description;
            $this->destination_id = $event->destination_id;
            $this->start_date = $event->start_date->format('Y-m-d');
            $this->end_date = $event->end_date->format('Y-m-d');
            $this->address = $event->address;
            $this->capacity = $event->capacity;
            $this->price = $event->price;
            $this->organizer = $event->organizer;
            $this->contact_info = $event->contact_info;
            $this->imageUrl = $event->image_url;
            $this->status = $event->status;
            $this->modalTitle = 'ویرایش رویداد';
        } else {
            $this->modalTitle = 'ایجاد رویداد جدید';
            $this->start_date = now()->format('Y-m-d');
            $this->end_date = now()->addDays(1)->format('Y-m-d');
        }
        
        $this->showModal = true;
    }

    public function deleteEvent($id)
    {
        Event::find($id)->delete();
        session()->flash('success', 'رویداد با موفقیت حذف شد');
    }

    public function removeImage()
{
    $this->image = null;
    $this->imageUrl = null;
}
    public function render()
    {
        return view('livewire.admin.events', [
            'events' => Event::query()
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhereHas('destination', function($q) {
                              $q->where('name', 'like', '%' . $this->search . '%');
                          });
                })
                ->when($this->statusFilter, function ($query) {
                    $query->where('status', $this->statusFilter);
                })
                ->orderBy('start_date', 'desc')
                ->paginate($this->perPage),
            'destinations' => Destination::all()
            ])->layout('layouts.admin', ['title' => 'داشبورد مدیریت']);
        }
}