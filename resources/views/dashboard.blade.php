<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <title>GMcalendar</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200, 600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/index.css')}}">
    </head>
    <x-app-layout>
        <x-slot name="header">
            <body>
                <div>My group</div>
                <br><br>
                <div class="posts">
                    @foreach($posts as $post)
                        @if(Auth::user()->posts->contains($post))
                            <div class='post'>
                                <h2 class='title'>
                                    <a href="/posts/{{$post->id}}">{{$post->title}}</a>
                                </h2>

                                <p class='body'>{{$post->body}}</p>
                    
                                <br>
                            </div>
                        @endif
                    @endforeach
                    </div>     
            </body>
        </x-slot>
    </x-app-layout>

</html>