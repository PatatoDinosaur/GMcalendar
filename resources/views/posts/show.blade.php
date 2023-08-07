<!DOCTYPE HTML>
<html lang="{{str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!--Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
        <x-app-layout>
            <x-slot name="header">
                <body>
                    <h1 class="title">
                        {{$post->title}}
                    </h1>
                    <div class="category">
                        <a href="/categories/{{$post->category->id}}">{{$post->category->name}}</a>
                    </div>
                    <div class="content">
                        <div class="content__post">
                            <h3>グループの説明</h3>
                            <p>{{$post->body}}</p> 
                        </div>
                    </div>
                    <h3></h3>
                    <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FTokyo&showPrint=0&showTitle=0&src=cGVuZ3Jpa3VAZ21haWwuY29t&src=OThjNjIwMjI1YzY5M2YxYTMzZjg2NTFjMmQ4MTY3ZDVlMDZmODIxMGY5MGM5OWUxYzQ4M2NjOGE4ZGVmZDMxN0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=amEuamFwYW5lc2UjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%23E4C441&color=%2333B679&color=%230B8043" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no">
                        
                    </iframe>
                    <h3>開始時刻</h3>
                    <input type = "time">
                    <div class="edit">
                        <a href="/posts/{{$post->id}}/edit">編集</a>
                    </div>
                    <div>
                        <a href="/posts/{{$post->id}}/chat">チャット</a>
                    </div>
                    <div class="footer">
                        <a href="/">戻る</a>
                    </div>
                </body>
            </x-slot>
        </x-app-layout>
</html>