<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Models\Message;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Post $post)
    {
        $message = Message::orderBy('created_at', 'desc')->get();
        return view('/post/posts/chat', compact('messages'))->with(['posts' => $post->getPaginateByLimit(20)]);
    }
    
    public function sendMessage(Request $request, Post $post, Message $message)
    {
        $request->validate([
            'message.content' => ['required', 'string'],
        ],[
            'required' => ':attribute は必須項目です',
            'max' => ':attribute は :max 文字以内で入力してください',
        ]);  
        $message = new Message();
        $message->content = $request->input('message.content');
        $message->post_id = $post->id;
        $message->user_id = $message->master_id = Auth::user()->id;
        $message->save();
        
        return redirect("posts/{$post->id}/chat");
    }
    
    public function showGroupChat($postId, Request $request)
    {
        $post = Post::findOrFail($postId);
        $messages = Message::where('post_id', $postId)->orderBy('created_at', 'DESC')->simplePaginate(10);
        return view('posts/chat', compact('post', 'messages'));
        
    }
    
}
