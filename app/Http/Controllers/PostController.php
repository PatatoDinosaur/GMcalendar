<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
    public function show(Post $post)
    {
        $path = app_path('resources/js/calendar.js');
        return view('posts/show')->with ([
            'post'=> $post,
            'path'=>$path
            ]);
        //'post'はbladeファイルで使う変数。$postはid=1のPostインスタンス
    }

    //投稿処理用の関数
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
}
