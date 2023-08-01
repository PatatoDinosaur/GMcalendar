<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
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
        //クライアントインスタンス生成
        $client = new \GuzzleHttp\Client();
        
        $url = 'https://teratail.com/api/v1/questions';
        
        $response = $client->request(
            'GET',
            $url,
            ['Bearer' => config('services.teratail.token')]
        );
        
        //API通信で取得したデータはjson形式のため、PHPファイル用に連想配列にデコード
        $questions = json_decode($response->getBody(), true);
        
        return view('posts/index')->with(['posts' => $post->getPaginateByLimit(5), 'questions' => $questions['questions'],]);//$postの中身を戻り値にする
        //blade内でつ悪変数'posts'と設定。'posts'の中身にgetを使い、インスタンス化した$postを代入
    } 
    //特定IDのpostを表示する
    public function show(Post $post)
    {
        return view('posts/show')->with (['post'=> $post]);
        //'post'はbladeファイルで使う変数。$postはid=1のPostインスタンス
    }
    /* 8-4で追加したブログ作成関数
    public function create()
    {
        return view('posts/create');
    }
    */
    //投稿処理用の関数
    public function store(Request $request, Post $post)
    {
        $input = $request['post'];
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);
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
    
    public function create(Category $category)
    {
        return view('posts.create')->with(['categories' => $category->get()]);
    }
}
