<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>NewGroup</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <x-app-layout>
        <x-slot name="header">
            <body class="anticliased">
                <h1>新規グループ</h1>
                <br>
                <form action="/posts/create" method="POST">
                    @csrf
                    <div class ="title">
                        <h2>グループ名</h2>
                        <input type="text" name="post[title]"/>
                    </div>
                    <div class="body">
                        <h2>グループ情報</h2>
                        <textarea name="post[body]" placeholder="みんなでワイワイやってます！"></textarea>
                    </div>
                    <div class = "access-type">
                        <h2>公開状態</h2>
                        <input type="radio" name="post[access_type]" value="private"> 限定公開
                        <input type="radio" name="post[access_type]" value="public"> 公開
                    </div>
                    <br>
                    <input type="submit" value="作成"/>
                </form>
                <div class = "footer">
                    <a href="/">戻る</a>
                </div>
            </body>
        </x-slot>
    </x-app-layout>
</html>