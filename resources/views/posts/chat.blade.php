<!DOCTYPE HTML>
<script type=php>
    use Illuminate\Support\Facades\Auth;
</script>

<html lang="{{str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!--Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('/css/group.css')}}">
        
        
    </head>
        <x-app-layout>
            <x-slot name="header">
                <body>
                    <div class="chat-container">
                        <!-- チャット送信機能 -->
                        <div class="chat-input">
                            <form action="/posts/{{ $post->id }}/chat" method="POST">
                                @csrf
                                <textarea name="message[content]" placeholder="メッセージを入力"></textarea>
                                <button id ="send-button" class="chat-button">送信</button>
                            </form>
                        </div>
                        <!-- チャット表示機能 -->
                        <div class="chat-messages">
                            @foreach($messages as $message)
                           
                                <div class="message">
                                    <p class="message-text">{{$message->content}}</p>
                                    <span class="message-info">{{$message->user->name}} {{$message->created_at}}</span>
                                </div>
                            @endforeach
                            {{ $messages->links() }}
                        </div>

                        <script>
                            const chatForm = document,getElementById('chat-form');
                            const messageContent = document.getElementById('message-content');
                            
                            chatForm.addEventListener('submit', function(event){
                                messageContent.value = '';//チャットが送信されたら入力欄をクリア
                            });
                            
                        </script>
                    </div>
                    <div class="chat">
                        <a href="/posts/{{$post->id}}/chat">データ更新</a>
                    </div>
                    <div class="footer">
                        <a href="/posts/{{$post->id}}">戻る</a>
                    </div>
                </body>
                
            </x-slot>
        </x-app-layout>
</html>




