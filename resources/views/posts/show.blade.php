<!DOCTYPE HTML>
<html lang="{{str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!--Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,600">
        <!--Calendar-->
        <link rel="stylesheet" href="{{asset('/css/calendar.css')}}">
        <link rel="stylesheet" href="{{asset('/css/group.css?202')}}">
        
        <meta name="csrf-token" content="{{csrf_token()}}">
    </head>
        <x-app-layout>
            <x-slot name="header">
                <body>
                    <h1 class="title">
                        {{$post->title}}
                    </h1>
                    
                    <div class="content">
                        <div class="content__post">
                            <p>{{$post->body}}</p> 
                        </div>
                    </div>
                    <!-- グループに所属する人のみカレンダー等の機能表示 -->
                @if(Auth::user()->posts->contains($post))
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
                            <form action="/posts/{{$post->id}}/add" method="POST">
                                @csrf
                                日付:
                                <input type="date" id="eventDate" name="event[date]" oninput="checkDate()">
                                <input type="text" id="eventTitle" name="event[title]" placeholder="イベント名">
                                <h3>開始時刻</h3>
                                <input type="time" id="eventTime" name="event[time]">
                                <input type="submit"/>
                                
                            </form>
                            <div id="event-container"></div>
                        </div>
                        <br>
                        <!-- イベント表示 -->
                        <div class="event-detail-today" id="eventDetail-today" style="display:block">
                            <p>---今日の予定---</p>
                            @foreach($post->events()->orderBy('date', 'asc')->get() as $event)
                                @if($event->date->isToday())
                                <div class="inline-container">
                                    <p class="event-title">{{$event->title}}：{{$event->date->format('Y-m-d')}} {{$event->time}}~</p>
                                    <form action="/posts/{{$post->id}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{$event->id}}">
                                        <button type="submit" class="participate-button">参加</button>
                                    </form>
                                    
                                </div>
                                <div class="event-info">
                                        <div class="members">
                                            <a href="/posts/{{$post->id}}/members?event_id={{$event->id}}">参加者一覧</a>
                                        </div>
                                        @if(Auth::user()->id == $event->master_id)<div></div>
                                            <form action="/posts/{{ $post->id }}/cancel" id="form_{{ $post->id}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="delete" type="button" onclick="deleteEvent({{$post->id}}, '{{$event->title}}')">予定を削除</button>
                                            </form>
                                        @endif
                                        <br>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="event-detail-future" id="eventDetail" style="display:none;">
                            <p>---今後の予定---</p>
                            @foreach($post->events()->orderBy('date', 'asc')->get() as $event)
                                @if($event->date->isFuture())
                                <div class="inline-container">
                                    <p class="event-title">{{$event->title}}：{{$event->date->format('Y-m-d')}} {{$event->time}}~</p>
                                    <form action="/posts/{{$post->id}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{$event->id}}">
                                        <button type="submit" class="participate-button">参加</button>
                                    </form>
                                    
                                </div>
                                <div class="event-info">
                                        <div class="members">
                                            <a href="/posts/{{$post->id}}/members?event_id={{$event->id}}">参加者一覧</a>
                                        </div>
                                        @if(Auth::user()->id == $event->master_id)<div></div>
                                            <form action="/posts/{{ $post->id }}/cancel" id="form_{{ $post->id}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="delete" type="button" onclick="deleteEvent({{$post->id}}, '{{$event->title}}')">予定を削除</button>
                                            </form>
                                        @endif
                                        <br>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div> 
                    
                <script>var postId = {{$post->id}}</script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    
                    <div class="delete-post">
                        <form action="/posts/{{ $post->id }}/quit" id="form_{{ $post->id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="quit-button" onclick="quitPost({{$post->id}})">退会</button>
                        </form>
                    </div>

                    @if($user->id == $post->master_id)
                    <div class="delete">
                        <form action="/posts/{{ $post->id }}/delete" id="form_{{ $post->id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="button" onclick="deletePost({{$post->id}})">グループを削除</button>
                        </form>
                    </div>
                    @endif

                    <script>
                        function quitPost(id)
                        {
                            'use strict'
                        
                            if(confirm('このグループを退会します。\n本当に退会しますか？')){
                                document.getElementById(`form_${id}`).submit();
                            }
                        }

                        function deletePost(id)
                        {
                            'use strict'
                        
                            if(confirm('このグループを削除します。\n本当に退会しますか？')){
                                document.getElementById(`form_${id}`).submit();
                            }
                        }
                    </script>
                <!-- 所属していない場合には加入申請を送るためのボタンを表示 -->
                @else
                    <div class="join-group">
                        <form action="/posts/{{$post->id}}/join" method="POST">
                            @csrf
                            <button type="submit">加入</button>
                        </form>
                    </div>
                @endif
                <br>
                <div>
                    <div class="footer">
                        <a href="/dashboard">戻る</a>
                    </div>
                </div>
                </body>
            </x-slot>
        </x-app-layout>
</html>