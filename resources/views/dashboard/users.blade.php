@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <h1 class="text-2xl font-extrabold ml-5">Users List</h1>
    <ul class="flex flex-col gap-4 flex-1 bg-white rounded-xl p-4">
        @foreach ($users as $user)
        <li class="bg-green-500 rounded-xl p-2 drop-shadow-lg font-bold flex items-center">
                <h2 class="flex gap-4 text-md items-center">
            <img src="{{$user->photo_url}}" class="rounded-full w-12 h-12 object-cover shadow-md" alt="">
            <a href="{{url('/users/' . $user->id)}}" class="self-center text-ellipsis whitespace-nowrap overflow-hidden">{{$user->name}}</a>
                </h2>
            @if ($user->id != Auth::user()->id)
                <a href="{{url('/chats/' . $user->id)}}" class="ml-auto"><x-heroicon-o-chat-bubble-oval-left-ellipsis class="w-8 h-auto"/></a>
            @endif
        </li>

        @endforeach
    </ul>
</div>
@endsection