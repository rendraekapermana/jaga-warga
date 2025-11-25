<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        
        if ($currentUser->role === 'Psychologist') { // Ensure 'Psychologist' matches DB case
            // === PSYCHOLOGIST VIEW ===
            // Get users who have chatted (sent/received) with this psychologist
            
            // 1. Find all messages involving this psychologist
            $messages = Message::where('sender_id', $currentUser->id)
                            ->orWhere('receiver_id', $currentUser->id)
                            ->get();

            // 2. Get unique IDs of the other party
            $clientIds = $messages->map(function ($msg) use ($currentUser) {
                return $msg->sender_id == $currentUser->id ? $msg->receiver_id : $msg->sender_id;
            })->unique();

            // 3. Get User data based on those IDs
            $users = User::whereIn('id', $clientIds)->get();
            
            $pageTitle = 'Riwayat Chat Pasien';
            $emptyMessage = 'Belum ada pasien yang menghubungi Anda.';

        } else {
            // === REGULAR USER VIEW ===
            // Show all available Psychologists
            $users = User::where('role', 'Psychologist') // Ensure 'Psychologist' matches DB case
                         ->where('id', '!=', $currentUser->id)
                         ->get();
            
            $pageTitle = 'Daftar Psikolog Tersedia';
            $emptyMessage = 'Belum ada psikolog yang tersedia saat ini.';
        }

        return view('consultation', compact('users', 'pageTitle', 'emptyMessage'));
    }

    public function show($userId)
    {
        $receiver = User::findOrFail($userId);
        $currentUserId = Auth::id();

        // Fetch message history between current user and receiver
        $messages = Message::where(function($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $currentUserId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('receiver', 'messages'));
    }

    public function store(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Create the message
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->message, // Ensure column name is 'message' in DB, or change to 'content'
        ]);

        $broadcastStatus = 'success';
        try {
            // Broadcast event if broadcasting is set up
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
            Log::error('Broadcast Error: ' . $e->getMessage());
            $broadcastStatus = 'failed: ' . $e->getMessage();
        }

        return response()->json([
            'status' => 'Message Sent!',
            'broadcast_status' => $broadcastStatus,
            'message' => $message->load('sender'),
        ]);
    }
}