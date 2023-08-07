<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Post;

class ChatController extends Controller
{
    public function index(Post $post)
    {
        $messages = Message::orderBy('created_at', 'asc')->get();
        return view('posts/chat', compact('messages'))->with(['post'=>$post]);
    }
    
    public function getMessages()
    {
        $messages = Message::orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }
    
    public function sendMessage(Request $request)
    {
        $message = new Message();
        $message->content = $request->input('content');
        $message->save();
        return response()->json(['status' => 'success']);
    }
    
    public function showGroupChat($post)
    {
        $post = Group::findOrFail($postId);
        $messages = Message::where('group_id', $postId)->orderBy('created_at', 'asc')->get();
        return view('group_chat', compact('group', 'message'));
    }
}
