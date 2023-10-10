<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('HOME') }}
            </h2>
            <link rel="stylesheet" href="{{url('css/index.css')}}"></link>
        </x-slot>
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("My group") }}
                    </div>
                </div>
                    <div class="posts">
                    @foreach($posts as $post)
                        @if(Auth::user()->posts->contains($post))
                            <div class='post'>
                                <h2 class='title'>
                                    <a href="/posts/{{$post->id}}">{{$post->title}}</a>
                                </h2>
                                <!--
                                <p class="category">
                                    <a href="/categories/{{$post->category->id}}">{{$post->category->name}}</a>
                                </p>
                                -->
                                <p class='body'>{{$post->body}}</p>
                    
                                <br>
                            </div>
                        @endif
                    @endforeach
                    </div>                    
            </div>

        </div>

    </x-app-layout>
</html>