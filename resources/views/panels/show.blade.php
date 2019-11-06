@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 py-8 border border-b w-full">
        <div class="container">
            <div class="flex items-center">
                <div class="w-1/2">
                    <div class="flex items-center">
                        <img src="{{ asset('images/avatar.svg') }}" alt="Avatar" class="w-16 mr-2">
                        <h3 class="font-bold text-gray-700 tracking-wide">{{ $user->name }}</h3>
                    </div>
                </div>

                <div class="w-1/2 text-right">
                        @if (auth()->user()->hasRequestedFollowing($user))
                            <form action="/following/{{ $user->id }}/cancel" method="POST">
                                @csrf
                                <button class="bg-red-100 text-red-700 rounded px-4 py-2 shadow">Cancel Request</button>
                                <!-- auth user can cancel his follow request -->
                            </form>
                        @else
                            <form action="/members/{{ $user->id }}" method="POST">
                                @csrf
                                <button class="bg-green-100 text-green-700 rounded px-4 py-2 shadow">Follow</button>
                                <!-- send follow request to $user , status = suspended -->
                            </form>
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection
