<!DOCTYPE html>
<html lang="{{str_replace('_','-', app()->getLocale())}}">

    <head>
        <meta charset="utf-8">
        <title>GMcalendar</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200, 600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/group.css')}}">
    </head>

    <x-app-layout>
        <x-slot name="header">
            <body>
                <div>
                    <p class="event-title">{{$event->title}}：{{$event->date->format('Y-m-d')}} {{$event->time}}~
                </div>
                <div  class="event-member">
                    <p>参加するメンバー</p>
                </div>
                <br>
                <div class='members'>
                    
                    @foreach($users as $user)
                        @if($event->users->contains($user))
                            <li>{{$user->name}}：{{$user->schedule->time_start}}~{{$user->schedule->time_end}}</li>
                        @endif
                    @endforeach
                </div>
                <br>
                <div class="footer">
                    <a href="/posts/{{$post->id}}">戻る</a>
                </div>

            </body>
        </x-slot>
    </x-app-layout>
</html>