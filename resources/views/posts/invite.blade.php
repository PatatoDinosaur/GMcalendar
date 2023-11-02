<!DOCTYPE html>
<html lang="{{str_replace('_','-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <title>招待するユーザー</title>
                <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200, 600" rel="stylesheet">
    </head>
    <body>
        <h1>招待するユーザー</h1>
        
        <form id="addRequest" action="/posts/{{$post->id}}/invite" method="POST">
            @csrf
            <input type="hidden" id="userId" name="userId">

            
            <div class="invite">
                @foreach ($users as $user)
                    @if(!$user->posts->contains($post))
                    <li>{{ $user->name }} <button type="submit" onclick="inviteUser({{$user->id}}, '{{$user->name}}')">招待</button></li>
                    @endif
                @endforeach
            </div>

            <div class="footer">
                <a href="/posts/{{$post->id}}">戻る</a>
            </div>
            <script>
                function inviteUser(id, name)
                {
                    'use strict'
                    if(confirm(name + 'さんを招待します。\nよろしいですか？')){
                        document.getElementById("userId").value = id;
                        document.getElementById("addRequest").submit();
                    }
                    
                }
            </script>
        </form>
    </body>
</html>