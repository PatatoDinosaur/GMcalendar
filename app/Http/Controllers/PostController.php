<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Event;
use App\Models\User;
use App\Models\Message;
use App\Models\Category;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        return view('posts/index')->with(['posts' => $post->getPaginateByLimit(8)]);
    } 
    //特定IDのpostを表示する
    public function show(Post $post, Event $event)
    {
        $path = app_path('resources/js/calendar.js');
        $user = Auth::user();
        $schedule = $user->schedule();
        return view('posts/show')->with ([
            'post'=> $post,
            'path'=>$path,
            'events'=>$event->get(),
            'user' => $user,
            'schedule' => $schedule,
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
        $request->validate([
            'post.title' => ['required', 'string'],
            'post.body' => ['string', 'max:50'],
            'post.access_type' => ['required'],
            ],
            [
            'required' => ':attribute は必須項目です',
            'max' => ':attribute は :max 文字以内で入力してください',
        ]);        
        $input = $request['post'];
        $post->fill($input)->save();
        $post->master_id = Auth::user()->id;
        Auth::user()->posts()->attach([$post->id]);//所属するグループを新規登録
        return redirect('/posts/' . $post->id);
    }
    
    public function joinGroup(Post $post)
    {
        Auth::user()->posts()->attach([$post->id]);
        return redirect('/posts/' . $post->id);
    }
    
    public function quit(Post $post)
    {
        Auth::user()->posts()->detach($post->id);
        return redirect('/');
    }
    
    public function edit(Post $post)
    {
        return view('posts/edit')->with(['post' => $post]);
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
    
    public function create()
    {
        return view('posts/create');
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
        $user->posts()->attach([$post->id]);//所属するグループを新規登録
        return redirect('/posts/' . $post->id);        
     }
     
    public function attributes()
    {
        return [
            'post.title' => 'グループ名',
            'post.body' => 'グループ情報',
            'post.access_type' => '公開状態',
        ];
    }
    
    public function serchUser(Request $request)
    {
        $users = User::paginate(20);
        $search = $request->input('search');
        $query = User::query();

        if ($search) {

            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search, 's');
            
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $query->where('name', 'like', '%'.$value.'%');
            }

            $users = $query->paginate(20);

        }

        return view('/posts/' . $post->id)->with(['users' => $users, 'search' => $search]);
    }
     
}
?>
