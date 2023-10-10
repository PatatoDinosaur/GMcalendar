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
    
    public function getUsersCountByDay(Request $request) {
        
        $counts = [
            'sunday' => Schedule::where('sunday', true)->count(),
            'monday' => Schedule::where('monday', true)->count(),
            'tuesday' => Schedule::where('tuesday', true)->count(),
            'wednesday' => Schedule::where('wednesday', true)->count(),
            'thursday' => Schedule::where('thursday', true)->count(),
            'friday' => Schedule::where('friday', true)->count(),
            'saturday' => Schedule::where('saturday', true)->count(),
        ];
        return response()->json($counts);
    }

}