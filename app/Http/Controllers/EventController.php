<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Event;
use App\Models\Category;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    //イベント投稿処理用の関数
    public function add(Request $request, Event $event, Post $post)
    {
        $input = $request['event'];
        $event->fill($input)->save();
        $post->events()->save($event);
        return redirect('/posts/' . $post->id);
    }
   
    public function getEvent(Post $post)
    {
        return view('posts/index')->with(['posts' => $post->getPaginateByLimit(5)]);
    }

    public function show(Post $post, Category $category)
    {
        $path = app_path('resources/js/calendar.js');
        return view('posts/show')->with ([
            'post'=> $post,
            'path'=>$path,
            'category'=>$category
            ]);
        //'post'はbladeファイルで使う変数。$postはid=1のPostインスタンス
    }

}