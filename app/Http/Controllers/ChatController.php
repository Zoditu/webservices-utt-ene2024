<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;


class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('chat.index', compact('messages'));
        return view('chats');
    }
}

/*
class ChatController extends Controller
{
    public function index()
    {
        return view('chats');
    }
}
*/