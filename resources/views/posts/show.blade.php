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
    <!--                <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FTokyo&showTitle=0&showTz=0&showTabs=1&showPrint=0&src=OThjNjIwMjI1YzY5M2YxYTMzZjg2NTFjMmQ4MTY3ZDVlMDZmODIxMGY5MGM5OWUxYzQ4M2NjOGE4ZGVmZDMxN0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=amEuamFwYW5lc2UjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23E4C441&color=%230B8043" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>
    -->             <div class="container-calendar">
                        <h4 id="monthAndYear"></h4>
                        <div class="button-container-calendar">
                            <button id="previous" onclick="previous()">‹</button>
                            <button id="next" onclick="next()">›</button>
                        </div>
                      
                        <table class="table-calendar" id="calendar" data-lang="ja">
                            <thead id="thead-month"></thead>
                            <tbody id="calendar-body"></tbody>
                        </table>
                      
                        <div class="footer-container-calendar">
                            <label for="month">日付指定：</label>
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
                </div>
                <script src="{{url('js/calendar.js')}}" type="text/javascript"></script>
                    
                    <h3>開始時刻</h3>
                    <input type = "time">

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