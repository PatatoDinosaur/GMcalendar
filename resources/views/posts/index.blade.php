<!DOCTYPE html>
<html lang="{{str_replace('_','-', app()->getLocale())}}">

    <head>
        <meta charset="utf-8">
        <title>GMcalendar</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200, 600" rel="stylesheet">
    </head>

    <x-app-layout>
        <x-slot name="header">
            <body>
                <h1>グループ</h1>
                <a href='/posts/create'>新規作成</a>
                <br>
                <div class='posts'>
                    @foreach($posts as $post)
                        <div class='post'>
                            <h2 class='title'>
                                <a href="/posts/{{$post->id}}">{{$post->title}}</a>
                            </h2>
                            <p class="category">
                                <a href="/categories/{{$post->category->id}}">{{$post->category->name}}</a>
                            </p>
                            <p class='body'>{{$post->body}}</p>
                    
                            <form action="/posts/{{ $post->id }}" id="form_{{ $post->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deletePost({{$post->id}})">delete</button>
                            </form>
                            <br>
                        </div>
                    @endforeach
                </div>
                    <p>
                        ログインユーザー:{{Auth::user()->name}}
                    </p>

                <script>
                    function deletePost(id)
                    {
                        'use strict'
                        
                        if(confirm('削除すると復元できません。\n本当に削除しますか？')){
                            document.getElementById(`form_${id}`).submit();
                        }
                    }
                </script>
            </body>
        </x-slot>
    </x-app-layout>
        
</html>