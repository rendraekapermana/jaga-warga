<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Pastikan ini ada

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('consultation', compact('users'));
    }

    public function show($userId)
    {
        $receiver = User::findOrFail($userId);
        $currentUserId = Auth::id();

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

        // 1. Simpan ke Database (Pasti Berhasil)
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->message,
        ]);

        // 2. Broadcast ke Reverb (Rawan Error, kita bungkus try-catch)
        $broadcastStatus = 'success';
        try {
            // Kode ini yang memicu error 500 jika Reverb gagal
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            // JIKA ERROR: Jangan tampilkan error 500 ke user!
            // Cukup catat di log server, dan biarkan program lanjut jalan.
            Log::error('Reverb Error: ' . $e->getMessage());
            $broadcastStatus = 'failed';
        }

        // 3. Return Sukses 200 (User tidak akan melihat error merah lagi)
        return response()->json([
            'status' => 'Message Sent!',
            'broadcast_status' => $broadcastStatus,
            'message' => $message->load('sender'),
        ]);
    }
}