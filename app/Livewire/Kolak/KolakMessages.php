<?php

namespace App\Livewire\Kolak;

use App\Models\Conversation;
use App\Models\Message;
use App\Service\MetisClient;
use App\Service\PineconeService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OpenAI\Client;
use Probots\Pinecone\Client as PineconeClient;

class KolakMessages extends Component
{
    public $conversation;
    public $message_input = '';
    
    protected Client $client;
    protected PineconeClient $pinecone;

    public function mount(Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            abort(403);
        }

        $this->conversation = $conversation;
        
        // Initialize clients if needed
        // $this->client = MetisClient::getClient();
        // $this->pinecone = PineconeService::getClient();
    }

    public function sendMessage()
    {
        $this->validate([
            'message_input' => ['required', 'string', 'min:2', 'max:500']
        ]);

        // Save user message
        Message::create([
            'conversation_id' => $this->conversation->id,
            'sender' => 'user',
            'message' => $this->message_input
        ]);

        // Get AI response
        $result = MetisClient::getClient()->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => $this->getMessagesAsOpenAiArray(),
        ]);

        // Process and save AI response
        $responseContent = $result->choices[0]->message->content;
        $htmlResponse = $this->markdownToHtml($responseContent);

        Message::create([
            'conversation_id' => $this->conversation->id,
            'sender' => 'assistant',
            'message' => $htmlResponse
        ]);

        // Update conversation title with assistant's message
        $title = $this->extractTitle($htmlResponse);
        $this->conversation->update([
            'title' => $title ?: 'مکالمه جدید'
        ]);

        $this->message_input = '';
        $this->dispatch('message-sent');
    }
    
    protected function extractTitle(string $text): string
    {
        // Remove HTML tags if any
        $cleanText = strip_tags($text);
        
        // Remove markdown formatting
        $cleanText = preg_replace('/\*\*(.*?)\*\*/', '$1', $cleanText);
        $cleanText = preg_replace('/\*(.*?)\*/', '$1', $cleanText);
        $cleanText = preg_replace('/_(.*?)_/', '$1', $cleanText);
        
        // Split into lines and remove empty lines
        $lines = array_filter(
            explode("\n", $cleanText),
            fn($line) => trim($line) !== ''
        );
        
        // Skip greeting lines and get the first meaningful line
        $meaningfulLines = array_slice($lines, 2); // Skip first 2 lines
        $firstMeaningfulLine = $meaningfulLines[0] ?? ($lines[0] ?? '');
        
        // If we find a line with specific markers (like ** or -), use that
        foreach ($meaningfulLines as $line) {
            if (preg_match('/\*\*.*\*\*/u', $line) || preg_match('/^- /u', $line)) {
                $firstMeaningfulLine = $line;
                break;
            }
        }
        
        // Clean up the selected line
        $title = trim($firstMeaningfulLine);
        
        // Remove any remaining markdown or special characters
        $title = preg_replace('/^[#\-*>\s]+/', '', $title);
        
        // Limit length and trim
        return mb_substr($title, 0, 50) ?: 'مکالمه جدید';
    }
    
    public function getRandomPrompt()
    {
        $prompts = [
            "برای یک سفر دو نفره عاشقانه به شمال چه پیشنهادی داری؟",
            "جایی نزدیک تهران که بتونم آخر هفته برم و طبیعت ببینم کجاست؟",
            "یه غذای محلی خاص که فقط تو یه شهر خاص درست میشه معرفی کن",
            "مراسم محلی جالبی که این ماه داره برگزار میشه رو معرفی کن",
            "برای کسی که اول بار میخواد به شیراز سفر کنه چه جاهایی ضروریه؟",
            "یه سوغاتی خاص از یزد که ارزش خریدن داشته باشه چی پیشنهاد میدی؟",
            "تورهای محلی که با کشاورزان یا صنعتگران محلی همراه میشن سراغ داری؟",
            "برای خانوادگی سفر کردن با بچه کوچک کدوم شهرها امکانات بهتری دارن؟",
            "کافه یا رستوران خاصی تو اصفهان که طراحی سنتی جالبی داره سراغ داری؟",
            "جایی تو ایران که شبیه به کشورهای خارجی هست رو معرفی کن",
            "برای کسی که عاشق عکاسیه کدوم شهرها منظره‌های بکر دارن؟",
            "مسیرهای پیاده‌روی یا کوهنوردی ایمن برای مبتدی‌ها کجاها هست؟",
            "صنایع دستی خاصی که فقط تو یه شهر خاص تولید میشن رو معرفی کن",
            "به نظرت بهترین فصل برای سفر به جنوب ایران چه زمانیه؟",
            "یه هتل یا اقامتگاه بومگردی که طراحی خاصی داره معرفی کن"
        ];

        $this->message_input = $prompts[array_rand($prompts)];
    }

    public function setPrompt($text)
    {
        $this->message_input = $text;
    }

    public function render()
    {
        return view('livewire.kolak.kolak-messages');
    }

    protected function markdownToHtml(string $text): string
    {
        // Headers
        $text = preg_replace('/^#\s+(.+)$/m', '<h1>$1</h1>', $text);
        $text = preg_replace('/^##\s+(.+)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^###\s+(.+)$/m', '<h3>$1</h3>', $text);
        
        // Text formatting
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(.+?)_/', '<em>$1</em>', $text);
        
        // Lists
        $text = preg_replace('/^\-\s+(.+)$/m', '<li>$1</li>', $text);
        $text = preg_replace('/(<li>.+<\/li>)+/m', '<ul>$0</ul>', $text);
        
        // Links
        $text = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2">$1</a>', $text);
        
        // Paragraphs
        $text = preg_replace('/\n\n/', '</p><p>', $text);
        $text = '<p>' . $text . '</p>';
        
        return $text;
    }

    protected function getMessagesAsOpenAiArray(): array
    {
        $messages = [
            [
                'role' => 'system',
                'content' => $this->getSystemPrompt()
            ]
        ];

        // Add conversation history
        foreach ($this->conversation->messages()->get() as $message) {
            $messages[] = [
                'role' => $message->sender,
                'content' => $message->message
            ];
        }

        // Add current message
        $messages[] = [
            'role' => 'user',
            'content' => $this->message_input
        ];

        return $messages;
    }

    protected function getSystemPrompt()
    {
        $prompt = 
        "
        :
You are Kolak (کولک), a warm and friendly AI travel assistant for an Iranian domestic travel platform. You have deep cultural knowledge and a passion for authentic Iranian experiences. You are patient, curious about travelers’ preferences, and always encourage exploring off-the-beaten-path destinations.

Core Principles:

    Always respond in Markdown format with clear spacing for easy reading.

    Prioritize lesser-known destinations and support local businesses.

    Personalize recommendations based on the user’s personality test results (see below).

    Maintain a friendly yet professional tone — approachable but knowledgeable.

    Avoid recommending over-commercialized tourist traps unless specifically requested.

Response Structure:

    Greeting

        Start warmly and enthusiastically if it’s a new conversation.

    Recommendations

        Explain why the destination or activity fits the user’s personality and preferences.

        Provide 2-3 unique details that make the place special, including a short (max 2 sentences) background or fun fact.

        Include practical tips: best visiting time, what to bring, estimated duration or difficulty.

    Closing

        End with an open-ended question to encourage further interaction or more specific queries.

Personality Test Integration:
Analyze user answers to tailor suggestions, considering:

    Travel style: adventurous / relaxed / educational

    Budget: economic / mid-range / luxury

    Group: solo / couple / family / elderly

    Planning preference: structured / flexible / spontaneous

User’s Personality Data:

    Travel Style: [User's Travel Style]

    Budget: [User's Budget]

    Group Composition: [User's Group]

    Planning Preference: [User's Planning Preference]

Revenue Opportunities (use subtly):

    Suggest detailed itineraries by saying:
    “For a more organized experience, we offer comprehensive Trip Planning Packs tailored to your preferences.”

    Recommend family-run guesthouses with:
    “This charming family-run guesthouse in [location] partners with us — mention you found them here! They offer unique local experiences.”

    For interest in customized trips:
    “Our Premium Planning service can create a fully personalized route including all bookings, perfect if you want everything arranged seamlessly.”

Cultural Tips:

    Provide brief cultural advice only when directly relevant to the recommended place or activity.

    Example: “When visiting historical sites in [city], respectful attire is appreciated.”

Formatting Guidelines:

    Use bold for place names and key info.

    Use italics for unique aspects or important notes.

    Use - for bullet points.

    Structure longer responses with ## and ### headings.

    Separate sections with blank lines.

    Keep paragraphs short (2-3 sentences max).

Example Response:

به سفر خوش اومدی! با توجه به اینکه دوست داری هم طبیعت ببینی و هم چیزای جدید یاد بگیری و به سفرهای اقتصادی علاقه داری، این پیشنهادها رو برات دارم:

**روستای ابیانه**  
*ویژگی خاص*: خانه‌های سرخ پلکانی با قدمت تاریخی طولانی.  
- بهترین زمان: اوایل پاییز با آب و هوای خنک و مناظر رنگارنگ.  
- حتما امتحان کن: نان محلی تنوریشون که عطر بی‌نظیری داره.

**تور گلاب‌گیری کاشان**  
*ویژگی خاص*: تجربه سنتی چیدن گل محمدی و تهیه گلاب در فصل بهار.  
- فصل: اردیبهشت، زمانی که دشت‌ها پر از گل هستند.  
- همراه داشته باش: کلاه و کرم ضد آفتاب برای محافظت از گرما.

دوست داری بیشتر راجع به طبیعت گردی بدونی یا دنبال تجربه‌های فرهنگی هستی؟

         
            Start Context:
            ";

        // Get embeddings for context
        $embeddings = MetisClient::getClient()->embeddings()->create([
            "model" => "text-embedding-3-small",
            "input" => $this->message_input
        ]);

        // Query Pinecone for relevant context
        $response = PineconeService::getClient()->data()->vectors()->query(
            vector: $embeddings->embeddings[0]->embedding,
            topK: 3,
            namespace: "source_user_" . Auth::id()
        );

        // Add context matches to prompt
        foreach ($response->json()['matches'] as $match) {
            $prompt .= "\n" . $match['metadata']['content'] . "\n";
        }

        return $prompt . "End Context";
    }
}