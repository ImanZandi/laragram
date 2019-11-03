@extends('layouts.app')

@section('content')
    <div class="container">
        @forelse($users as $user)
            <li>{{ $user->name }}</li>
            @empty
            <p>User not found</p>
        @endforelse
    </div>
@endsection
