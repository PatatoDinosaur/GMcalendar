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
                    <div class="chat-container">
                        <!-- チャット表示機能 -->
                        <div class="chat-messages">
                            @foreach($messages as $message)
                                <div class="message">
                                    <p>{{$message->content}}</p>
                                    <span class="timestamp">{{$message->created_at->diffForHumans()}}</span>
                                </div>
                            @endforeach
                        </div>
                        <!-- チャット送信機能 -->
                        <div class="chat-input">
                            
                            <input type="text" id="message" placeholder="メッセージを入力">
                            <button id ="send-button">送信</button>
                        </div>                    
                    </div>
                    <div class="chat">
                        <a href="/posts/{{$post->id}}/chat">データ更新</a>
                    </div>
                    <div class="footer">
                        <a href="/posts/{{$post->id}}">戻る</a>
                    </div>
                </body>
                
                <script type ="text/javascript">
                
                const messageInput = document.getElementById('message');
                const sendButton = document.getElementById('send-button');
                
                sendButton.addEventListener('click', () => {
                    const messageContent = messageInput.value;
                    if (messageContent.trim() !== '') {
                        // Ajaxを使ってメッセージを送信
                        fetch('/send-message', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                content: messageContent
                            })
                        }).then(response => {
                            if (response.ok) {
                                // メッセージが送信された後に、メッセージ欄をクリアするなどの処理を行う
                                messageInput.value = '';
                            }
                        }).catch(error => console.error('エラーが発生しました:', error));
                    }
                });
                
                </script>
            </x-slot>
        </x-app-layout>
</html>




