<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\CommonChatController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chatList (CommonChatController $chatList) {
        // dd(auth()->id());
        $chats = $chatList->chat(auth()->id());
        // return $chats;
        return view('web.business.chat.index', compact('chats'));
    }
}
