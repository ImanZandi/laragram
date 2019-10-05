@extends('layouts.master')

@section('content')
    <div class="w-3/4 mx-auto py-12 bg-green-100">
        <form action="/posts" method="post" enctype="multipart/form-data" class="mb-8">
            @csrf
            <input-file></input-file>
            {{--
            <label for="img" class="border-dashed border-2 border-gray-400 px-12 py-12 rounded h-64 flex items-center text-center justify-center text-5xl text-gray-400 mb-4">+</label>
            <input class="hidden" type="file" name="image" id="img">
            --}}
            <button class="bg-blue-300 text-white px-12 py-2 rounded-full" type="submit">Upload</button>
        </form>

        <div class="flex flex-wrap -mx-6">
            @foreach ($posts as $post)
                <div class="w-1/3 mb-12">
                    <div class="px-6">
                        <div style="background-image: url({{ asset('storage/' . $post->path) }}); background-repeat: no-repeat; background-size: cover;" class="w-full h-64 rounded"></div>
                        <!-- or -->
                        {{-- <img src="/storage/{{ $post->path }}" alt="test" class="w-full"> --}}
                        <!-- view can read image just in this directory -->
                        <!-- public/storage/images/test.jpeg -->
                        <!-- this directory linked to storage/app/public/images/test.jpeg -->
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
