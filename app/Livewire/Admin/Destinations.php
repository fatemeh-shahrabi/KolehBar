<?php

namespace App\Livewire\Admin;

use App\Models\Destination;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Destinations extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // For create/edit
    public $showModal = false;
    public $modalTitle = '';
    public $destinationId = null;
    public $name = '';
    public $description = '';
    public $city = '';
    public $province = '';
    public $address = '';
    public $best_time_to_visit = '';
    public $rating = 4;
    public $image;
    public $imageUrl;
    public $is_featured = false;

// app/Livewire/Admin/Destinations.php

protected $rules = [
    'name' => 'required|min:3',
    'description' => 'required|min:10',
    'city' => 'required',
    'province' => 'required',
    'address' => 'required', // Add this
    'rating' => 'numeric|min:1|max:5',
    'image' => 'nullable|image|max:2048',
];

public function saveDestination()
{
    $this->validate();

    $data = [
        'name' => $this->name,
        'description' => $this->description,
        'city' => $this->city,
        'province' => $this->province,
        'address' => $this->address,
        'best_time_to_visit' => $this->best_time_to_visit,
        'rating' => $this->rating,
        'is_featured' => $this->is_featured,
        'location' => $this->city, // Add default location
        'category' => 'general', // Add default category
    ];

    try {
        if ($this->image) {
            $path = $this->image->store('destinations', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        if ($this->destinationId) {
            Destination::find($this->destinationId)->update($data);
            session()->flash('success', 'مقصد با موفقیت ویرایش شد');
        } else {
            Destination::create($data);
            session()->flash('success', 'مقصد جدید با موفقیت ایجاد شد');
        }

        $this->showModal = false;
        $this->reset(); // Reset all properties
    } catch (\Exception $e) {
        session()->flash('error', 'خطا در ذخیره مقصد: ' . $e->getMessage());
    }
}
    public function openModal($id = null)
    {
        $this->reset(['name', 'description', 'city', 'province', 'address', 
                     'best_time_to_visit', 'rating', 'image', 'imageUrl', 'is_featured']);
        
        if ($id) {
            $destination = Destination::findOrFail($id);
            $this->destinationId = $id;
            $this->name = $destination->name;
            $this->description = $destination->description;
            $this->city = $destination->city;
            $this->province = $destination->province;
            $this->address = $destination->address;
            $this->best_time_to_visit = $destination->best_time_to_visit;
            $this->rating = $destination->rating;
            $this->imageUrl = $destination->image_url;
            $this->is_featured = $destination->is_featured;
            $this->modalTitle = 'ویرایش مقصد';
        } else {
            $this->modalTitle = 'ایجاد مقصد جدید';
        }
        
        $this->showModal = true;
    }

    public function deleteDestination($id)
    {
        Destination::find($id)->delete();
        session()->flash('success', 'مقصد با موفقیت حذف شد');
    }

    public function removeImage()
{
    $this->image = null;
    $this->imageUrl = null;
}
    public function render()
    {
        return view('livewire.admin.destinations', [
            'destinations' => Destination::query()
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('city', 'like', '%' . $this->search . '%')
                          ->orWhere('province', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ])->layout('layouts.admin', ['title' => 'داشبورد مدیریت']);
    }
}