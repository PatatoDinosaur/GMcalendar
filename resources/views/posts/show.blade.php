<!DOCTYPE HTML>
<html lang="{{str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!--Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!--Calendar-->
        <link rel="stylesheet" href="{{url('css/calendar.css')}}">
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
                    <div class="container-calendar">
                        <h4 id="monthAndYear"></h4>
                        <div class="button-container-calendar">
                            <button id="previous" onclick="previous()">‹</button>
                            <button id="next" onclick="next()">›</button>
                        </div>
                      
                        <table class="table-calendar" id="calendar" data-lang="ja">
                            <thead id="thead-month"></thead>
                            <tbody id="calendar-body" onclick="eventForm.style.display='block'"></tbody>
                        </table>
                      
                        <div class="footer-container-calendar" >
                           
                            <!--<label for="month">日付指定：</label>-->
                            <select id="month" onchange="jump()">
                                <option value=0>1月</option>
                                <option value=1>2月</option>
                                <option value=2>3月</option>
                                <option value=3>4月</option>
                                <option value=4>5月</option>
                                <option value=5>6月</option>
                                <option value=6>7月</option>
                                <option value=7>8月</option>
                                <option value=8>9月</option>
                                <option value=9>10月</option>
                                <option value=10>11月</option>
                                <option value=11>12月</option>
                                
                            </select>
                            <select id="year" onchange="jump()"></select>
                        </div>
                        
                        <div class="events">
                            @foreach($post->events as $event)
                                <!-- イベントの確認 -->
                                <div class="event" data-year="{{$event->date->format('Y')}}" data-month="{{$event->date->format('m')}}" data-date="{{$event->date->format('d')}}">
                                </div>

                            @endforeach
                        </div>
                        
                        <div class="add-event-calendar" id="eventForm" style="display:none;">
                            <form action="/posts/{{$post->id}}" method="POST">
                                @csrf
                                日付:
                                <input type="date" id="eventDate" value="eventDate" name="event[date]">
                                <input type="text" id="eventTitle" name="event[title]" placeholder="イベント名">
                                <h3>開始時刻</h3>
                                <input type="time" id="eventTime" name="event[time]">
                                <input type="submit"/>
                            </form>
                        </div>   
                </div>
                <script src="{{url('js/calendar.js')}}" type="text/javascript"></script>
                
                    <div class="invite">
                        <a href="/posts/{{$post->id}}/invite">招待</a>
                    </div>    
                    <div class="edit">
                        <a href="/posts/{{$post->id}}/edit">編集</a>
                    </div>
                    <div class="chat">
                        <a href="/posts/{{$post->id}}/chat">チャット</a>
                    </div>
                    <div class="footer">
                        <a href="/">戻る</a>
                    </div>
                </body>
            </x-slot>
        </x-app-layout>
</html>