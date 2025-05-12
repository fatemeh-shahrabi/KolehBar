<?php

namespace App\Livewire\Conversation;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Source;
use App\Service\MetisClient;
use App\Service\PineconeService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OpenAI\Client;
use Probots\Pinecone\Client as PineconeClient;

class Messages extends Component
{
    public $conversation;

    public $message_input = '';

    protected Client $client;
    protected PineconeClient $pinecone;

    public function mount(Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) return abort(403);

        $this->conversation = $conversation;

        // $this->client = MetisClient::getClient();
        // $this->pinecone = PineconeService::getClient();
    }

    public function sendMessage()
    {
        $this->validate([
            'message_input' => ['required', 'string', 'min:2', 'max:500']
        ]);
    
        Message::create([
            'conversation_id' => $this->conversation->id,
            'sender' => 'user',
            'message' => $this->message_input
        ]);
    
        $result = MetisClient::getClient()->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => $this->getMessagesAsOpenAiArray(),
        ]);
    
        $responseContent = $result->choices[0]->message->content;
        $htmlResponse = $this->markdownToHtml($responseContent);
    
        Message::create([
            'conversation_id' => $this->conversation->id,
            'sender' => 'assistant',
            'message' => $htmlResponse
        ]);
    
        $this->message_input = '';
    }
    
    protected function markdownToHtml($text)
    {
        $text = preg_replace('/^#\s+(.+)$/m', '<h1>$1</h1>', $text);
        $text = preg_replace('/^##\s+(.+)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^###\s+(.+)$/m', '<h3>$1</h3>', $text);
        
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(.+?)_/', '<em>$1</em>', $text);
        
        $text = preg_replace('/^\-\s+(.+)$/m', '<li>$1</li>', $text);
        $text = preg_replace('/(<li>.+<\/li>)+/m', '<ul>$0</ul>', $text);
        
        $text = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2">$1</a>', $text);
        
        $text = preg_replace('/\n\n/', '</p><p>', $text);
        $text = '<p>' . $text . '</p>';
        
        return $text;
    }

    protected function getMessagesAsOpenAiArray()
    {
        $messages = [
            [
                'role' => 'system',
                'content' => $this->getSystemPrompt()
            ]
        ];

        foreach ($this->conversation->messages()->get() as $message) {
            $messages[] = [
                'role' => $message->sender,
                'content' => $message->message
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $this->message_input
        ];

        return $messages;
    }

    public function setPrompt($text)
    {
        $this->message_input = $text;
    }

    protected function getSystemPrompt()
    {
        // $prompt = "You are a helpful assistant with access to a document containing code snippets from a websites. Your task is to answer questions about the functionality and structure of these code snippets.
        //     Only answer the questions, provided in the context below. you MUST not answer to any question, if the data for it is not provided. Return the answer in HTML format.

        //     Start Context:
        // ";

        $prompt = "Role: You are a friendly and knowledgeable travel assistant for [Startup Name], a platform dedicated to authentic, culturally rich domestic travel in Iran. Your goal is to help users discover hidden gems, local traditions, festivals, food, and small businesses while encouraging deeper connections with Iran’s diverse regions.

        Guidelines:
        
            Tone: Warm, enthusiastic, and professional—like a local expert sharing personal recommendations.
        
            Focus: Prioritize lesser-known destinations, hyper-local experiences, and small businesses.
        
            Avoid: Generic tourist clichés or overhyped commercial spots unless explicitly requested.
        
        Key Tasks:
        
            Destination Discovery: Suggest unique towns, villages, or natural sites with cultural significance.
            Example: If you love handicrafts, consider visiting Zanjan for its knife-making workshops!
        
            Cultural Events: Share details about local festivals, rituals, or seasonal activities.
            Example: The ‘Rosewater Festival’ in Kashan happens every May—want details?
        
            Food & Shops: Recommend authentic, family-run eateries or artisan shops.
            Example: *In Isfahan, try the ‘Beryani’ at Haj Mahmoud’s, a 100-year-old eatery!*
        
            Trip Planning: Offer route suggestions, stopovers, or accommodations for personalized itineraries.
            Example: *For a 2-day road trip from Tehran to Masuleh, I’d suggest these scenic stops…*
        
        Revenue Hints (Subtle):
        
            Mention trip planning packs if users seek detailed itineraries.
            Example: For a full itinerary with bookings, check out our Trip Planning Packs!
        
            Highlight local businesses (potential advertisers).
            Example: This pottery workshop partners with us—tell them you found them here!
        
        User Engagement:
        
            Ask clarifying questions to refine suggestions.
            Example: Do you prefer nature or history-focused spots?
        
            End with a call-to-action.
            Example: Where shall we explore next?
        
            All your talks should be about finding best choos for that user, for example when user says give me some personality test, your test will help you to understand the user favorites and decide for the place.

            Start Context:
        ";

        $embeddings = MetisClient::getClient()->embeddings()->create([
            "model" => "text-embedding-3-small",
            "input" => $this->message_input
        ]);

        $response = PineconeService::getClient()->data()->vectors()->query(
            vector: $embeddings->embeddings[0]->embedding,
            topK: 3,
            namespace: "source_user_" . Auth::id()
        );

        $matches = $response->json()['matches'];

        foreach ($matches as $match) {
            $prompt = $prompt . "\n" . $match['metadata']['content'] . "\n";
        }

        return $prompt . "End Context";
    }

    public function render()
    {
        return view('livewire.conversation.messages');
    }
}