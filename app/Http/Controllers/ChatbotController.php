<?php

namespace App\Http\Controllers;

use App\Models\ChatBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ChatbotController extends Controller
{
    /**
     * Load FAQ data from JSON file.
     */
    private function loadFAQData()
    {
        $faqPath = storage_path('app/faq.json');

        if (!file_exists($faqPath)) {
            return [
                'initialMessage' => 'Hello! I\'m your PSITS Nexus assistant. How can I help you today?',
                'faqDatabase' => [],
                'commonQuestions' => []
            ];
        }

        $content = file_get_contents($faqPath);
        return json_decode($content, true);
    }

    /**
     * Find the best matching FAQ item for a query.
     */
    private function findBestMatch($query, $faqDatabase)
    {
        $lowerQuery = strtolower($query);

        // Exact match check
        foreach ($faqDatabase as $faq) {
            if (strpos($lowerQuery, strtolower($faq['question'])) !== false) {
                return $faq;
            }
        }

        // Keyword match
        foreach ($faqDatabase as $faq) {
            foreach ($faq['keywords'] as $keyword) {
                if (strpos($lowerQuery, strtolower($keyword)) !== false) {
                    return $faq;
                }
            }
        }

        return null;
    }

    /**
     * Show the chat interface with FAQ data.
     */
    public function index()
    {
        $faqData = $this->loadFAQData();

        // Get existing messages from database
        $messages = ChatBot::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        // Always create initial message for new users
        if ($messages->isEmpty()) {
            $initialMessage = new ChatBot();
            $initialMessage->user_id = Auth::id();
            $initialMessage->message = $faqData['initialMessage'];
            $initialMessage->is_bot = true;
            $initialMessage->save();

            $messages = ChatBot::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get();
        }

        return Inertia::render('ChatBot', [
            'faqData' => $faqData,
            'messages' => $messages,
        ]);
    }

    /**
     * Store a new chat message and generate a bot reply.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        // Load FAQ data
        $faqData = $this->loadFAQData();

        // Save user's message
        $userMessageId = DB::selectOne("
            INSERT INTO chat_bots (user_id, message, is_bot, created_at, updated_at) 
            VALUES (?, ?, false, ?, ?) 
            RETURNING id
        ", [Auth::id(), $validated['message'], now(), now()])->id;
        $userMessage = ChatBot::find($userMessageId);

        // Generate bot reply using FAQ logic
        $matchedFAQ = $this->findBestMatch($validated['message'], $faqData['faqDatabase']);

        if ($matchedFAQ) {
            $response = $matchedFAQ['answer'];
            $quickReplies = array_slice($matchedFAQ['quickReplies'], 0, 3);
        } else {
            $response = 'I understand you\'re asking about: "' . $validated['message'] . '". For more specific assistance, please contact our support team or try one of these common questions:';
            $quickReplies = array_slice($faqData['commonQuestions'], 0, 3);
        }

        // Save bot's reply
        $botReplyId = DB::selectOne("
            INSERT INTO chat_bots (user_id, message, is_bot, created_at, updated_at) 
            VALUES (?, ?, true, ?, ?) 
            RETURNING id
        ", [Auth::id(), $response, now(), now()])->id;
        $botReply = ChatBot::find($botReplyId);

        // Return JSON for Inertia to update without full page reload
        return response()->json([
            'userMessage' => $userMessage,
            'botReply' => $botReply,
            'quickReplies' => $quickReplies,
        ]);
    }

    /**
     * Clear the chat history.
     */
    public function clear()
    {
        ChatBot::where('user_id', Auth::id())->delete();

        return response()->json(['status' => 'cleared']);
    }
}
