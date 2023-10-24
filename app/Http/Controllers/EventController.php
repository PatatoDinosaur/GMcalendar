<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Event;
use App\Models\Schedule;
use App\Models\Category;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    //イベント投稿処理用の関数
    public function add(Request $request, Event $event, Post $post)
    {
        $request->validate([
            'event.date' => ['required'],
            'event.time' => ['required'],
            ],
            [
            'required' => ':attributeを入力してください']
);
        
        $input = $request['event'];
        $event->fill($input)->save();
        $post->events()->save($event);
        return redirect('/posts/' . $post->id);
    }
   
    public function getEvents(Request $request)
    {
        $date = $request->input('date');
        
        // $dateを使用してデータベースからイベントを取得
        $events = Event::whereDate('date', $date)->get();

        return response()->json($events);
    }
    
    public function getUsersCountByDay(Request $request, $postId) {
        $counts = [
            'sunday' => 0,
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 0,
            'thursday' => 0,
            'friday' => 0,
            'saturday' => 0,
        ];
            
        $post = Post::find($postId);
        //$user = Auth::user();//確認用コード
        $users = $post->users;
            foreach($users as $user){
                //$schedule = $user->schedule;
                $schedule = Schedule::find($user->schedule_id);
                //foreach($schedules as $schedule){
                        if($schedule->sunday)
                            $counts['sunday']++;
                        if($schedule->monday)
                            $counts['monday']++;
                        if($schedule->tuesday)
                            $counts['tuesday']++;
                        if($schedule->wednesday)
                            $counts['wednesday']++;
                        if($schedule->thursday)
                            $counts['thursday']++;
                        if($schedule->friday)
                            $counts['friday']++;
                        if($schedule->saturday)
                            $counts['saturday']++;
                    
                //}
            }
        return response()->json($counts);
    }

}