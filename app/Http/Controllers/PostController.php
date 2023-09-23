<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Event;
use App\Models\User;
use App\Models\Message;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * Post一覧を表示する
     * 
     * @param Post Postモデル
     * @return array Post モデルリスト
     * 
     */
    public function index(Post $post)//インポートしたPostをインスタンス化して$postとして使用
    {
        return view('posts/index')->with(['posts' => $post->getPaginateByLimit(5)]);
    } 
    //特定IDのpostを表示する
    public function show(Post $post, Event $event)
    {
        $path = app_path('resources/js/calendar.js');
        return view('posts/show')->with ([
            'post'=> $post,
            'path'=>$path,
            'events'=>$event->get()
            ]);
        //'post'はbladeファイルで使う変数。$postはid=1のPostインスタンス
    }

    //イベント投稿処理用の関数
    public function add(Request $request, Event $event, Post $post)
    {
        $input = $request['event'];
        $event->fill($input)->save();
        return redirect('/posts/' . $post->id);
    }
    
    //グループ投稿処理用の関数
    public function store(Request $request, Post $post)
    {
        $input = $request['post'];
        $post->fill($input)->save();
        Auth::user()->posts()->sync([$post->id]);//所属するグループを新規登録
        return redirect('/posts/' . $post->id);
    }
    
    public function edit(Post $post, Category $category)
    {
        return view('posts/edit')->with(['post' => $post, 'categories' => $category->get()]);
    }
    
    public function chat(Post $post)
    {
        $post = Post::find($postId);
        //$messages =  $post->messages;
        return view('posts/chat')->with(['post' => $post]);
    }
    
    public function update(Request $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/posts/' . $post->id);
    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
    
    public function create(Category $category)
    {
        return view('posts/create')->with(['categories' => $category->get()]);
    }
    
    public function member(Post $post)
    {
        $users = $post->users;
    }
    
    public function invite(Post $post)
    {
        $users = User::all();
        return view('posts/invite')->with(['post' => $post, 'users' => $users]);
    }
    
    public function register(Post $post, Request $request)
    {
        $userId = $request->input('userId');
        $user = User::find($userId);
        $user->posts()->sync([$post->id]);//所属するグループを新規登録
        //dd($user->id);
        return redirect('/posts/' . $post->id);        
     }
}
?>
