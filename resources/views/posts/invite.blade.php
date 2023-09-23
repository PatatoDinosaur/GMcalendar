<!DOCTYPE html>
<html>
    <head>
        <title>ユーザー一覧</title>
    </head>
    <body>
        <form id="addRequest" action="/posts/{{$post->id}}/invite" method="POST">
            @csrf
            <input type="hidden" id="userId" name="userId">
            
            <h1>ユーザー一覧</h1>
            <div class="invite">
                @foreach ($users as $user)
                    <li>{{ $user->name }} <button type="button" onclick="inviteUser({{$user->id}}, '{{$user->name}}')">招待</button></li>
                @endforeach
            </div>
            <div class="footer">
                <a href="/">戻る</a>
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