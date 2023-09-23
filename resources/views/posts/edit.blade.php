<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel"stylesheet">
    </head>
    <x-app-layout>
        <x-slot name="header">
            <body>
                <h1 class="title">編集画面</h1>
                <div class="content">
                    <form action="/posts/{{$post->id}}"method="POST">
                        @csrf
                        @method('PUT')
                        <div class="content__title">
                            <h2>タイトル</h2>
                            <input type='text' name='post[title]' value="{{$post->title }}">
                        </div>
                        <div class="content__body">
                            <h2>本文</h2>
                            <input type='text' name='post[body]' value="{{$post->body}}">
                        </div>
                        <div class ="category">
                            <h2>カテゴリー</h2>
                            <select name="post[category_id]">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>                            
                        </div>
                        
                        <h2>公開状態</h2>
                        <input type="radio" name="post[access_type]" value="private"> 限定公開
                        <input type="radio" name="post[access_type]" value="public"> 公開
                        
                        <br>
                        
                        
                        <input type="submit" value="保存">
                    </form>
                </div>
                <div class="footer">
                    <a href="/posts/{{$post->id}}">戻る</a>
                </div>
            </body>
        </x-slot>
    </x-app-layout>
</html>