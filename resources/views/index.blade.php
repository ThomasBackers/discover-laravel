@extends('layouts.app')

@section('content')
  <div class="background-image grid grid-cols-1 m-auto">
    <div class="flex text-gray-100 pt-10">
      <div class="m-auto pt-4 pb-16 sm:m-auto w-4/5 block text-center">
        <h1 class="sm:text-white text-5xl uppercase font-bold text-shadow-md pb-14">
          Do you want to become a developer?
        </h1>

        <a href="/blog" class="text-center bg-gray-50 text-gray-700 py-2 px-4 font-bold txt-xl uppercase">
          Read More
        </a>
      </div>
    </div>
  </div>

  <div class="sm:grid grid-cols-2 gap-20 w-25 mx-auto py-15 border-b border-gray-200">
    <div>
      <img 
        src="https://cdn.pixabay.com/photo/2017/11/14/08/07/glasses-2947708_960_720.jpg"
        alt=""
        width="700"
      >
    </div>

    <div class="m-auto sm:m-auto text-left w-4/5 block">
      <h2 class="text-3xl"></h2>
    </div>
  </div>
@endsection
