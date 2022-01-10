@extends('layouts.app')

@section('content')
  <div class="w-4/5 m-auto text-center">
    <div class="py-15 border-b border-gray-200">
      <h1 class="text-6xl">
        Blog Posts
      </h1>
    </div>

    @if (session()->has('message'))
      <!-- So the message that coming from PostsController->store() -->
      <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-1/6 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4">
          {{ session()->get('message') }}
        </p>
      </div>
    @endif
    
    @if (Auth::check())
      <!-- if authentication is true -->
      <div class="pt-15 w-4/5 m-auto">
        <a 
          href="/blog/create"
          class="bg-blue-500 uppercase bg-transparent text-gray-100 text-xs font-extrabold px-5 py-3 rounded-3xl"
        >
          Create post
        </a>
      </div>
    @endif

    @foreach ($posts as $post)
      <div class="sm:grid grid-cols-2 gap-20 w-4/5 mx-auto py-15 border-b border-gray-200">
        <div>
          <img 
            src="{{ asset('images/' . $post->image_path) }}"
            alt=""
            width="700"
          >
        </div>

        <div>
          <h2 class="text-gray-700 font-bold text-5xl pb-4">
            {{ $post->title }}
          </h2>

          <span class="text-gray-500">
            By <span class="font-bold italic text-gray-800">
              {{ $post->user->name }}
            </span>, Created on {{ date('jS M Y', strtotime($post->updated_at)) }}

            <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
              {{ $post->description }}
            </p>

            <a
              class="uppercase bg-blue-500 text-gray-100 text-lg font-extrabold py-4 px-8 rounded-3xl"
              href="/blog/{{ $post->slug }}"
            >
              Keep Reading
            </a>

            <!-- Here we need an edit button but we only want to show it to the author if he's logged in -->
            @if (isset(Auth::user()->id) && Auth::user()->id == $post->user_id)
              <span class="float-right">
                <a
                  href="/blog/{{ $post->slug }}/edit"
                  class="text-gray-700 italic hover:text-gray-900 pb-1 border-b-2"
                >
                  Edit
                </a>
              </span>

              <span class="float-right">
                <form
                  action="/blog/{{ $post->slug }}"
                  method="POST"
                >
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="text-red-500 pr-3">
                    Delete
                  </button>
                </form>
              </span>
            @endif
          </span>
        </div>
      </div>
    @endforeach
  </div>
@endsection
