<?php

namespace App\Livewire\Kolak;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class KolakConversations extends Component
{
    public $conversations;
    public $confirmingDeletion = null;

    public function mount()
    {
        $this->loadConversations();
    }

    public function createConversation()
    {
        $conversation = Conversation::create([
            'user_id' => Auth::id(),
            'title' => 'مکالمه جدید'
        ]);

        $this->loadConversations();
        
        return redirect()->route('kolak.messages', $conversation->id);
    }

    public function confirmDelete($conversationId)
    {
        $this->confirmingDeletion = $conversationId;
    }

    public function deleteConversation($conversationId)
    {
        $conversation = Conversation::where('user_id', Auth::id())
                        ->where('id', $conversationId)
                        ->first();

        if ($conversation) {
            $conversation->delete();
            $this->confirmingDeletion = null;
            $this->loadConversations();
            
            session()->flash('message', 'مکالمه با موفقیت حذف شد');
        }
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = null;
    }

    public function render()
    {
        return view('livewire.kolak.kolak-conversations');
    }

    protected function loadConversations()
    {
        $this->conversations = Conversation::where('user_id', Auth::id())
                                ->latest()
                                ->get();
    }
}