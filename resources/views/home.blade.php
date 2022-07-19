@extends('template')

@section('content')
    <div class="flex justify-center flex-col items-center">
        <div class="mt-4 grid grid-cols-3 gap-3 2xl:grid-cols-6 place-items-center md:w-3/4 lg:grid-cols-4">
            @foreach($books as $b)
                <a class="item p-4 flex flex-col items-center justify-center rounded border gap-y-2 shadow text-start h-full" style="width: 200px;" href="/book/{{$b->id}}">
                    <img src="{{$b->cover}}" alt="" style="height: 200px" width="192.5">
                    @if(strlen($b->title) > 18)
                        <div class="w-full">{{substr(html_entity_decode($b->title), 0, 18)}}...</div>
                    @else
                        <div class="w-full">{{html_entity_decode($b->title)}}</div>
                    @endif
                    <h1 class="font-extrabold text-xl text-start w-full">$ {{$b->price}}</h1>
                </a>
            @endforeach
        </div>
        @if($books->total() > 36)
            <div class="pagination mt-4 mb-4 md:w-3/4 w-screen flex justify-center">
                @php
                    $i = $books->currentPage();
                    $start = 0;
                    $limit = 0;
                    if ($books->total() / 36 <= 10){
                        $start = 1;
                        $limit = $books->total() / 36 + 1;
                    } else if ($i + 10 > $books->lastPage()){
                        $limit = $books->lastPage();
                        $start = $limit - 10;
                    } else if ($i <= 10){
                        $limit = 10;
                        $start = 1;
                    } else {
                        $start = floor($i / 10) * 10;
                        $limit = $start + 10;
                    }
                @endphp
                <div class="">
                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    @if($books->onFirstPage())
                        <span rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 focus:z-10" aria-label="&amp;laquo; Previous">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <a href="{{$books->previousPageUrl()}}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="&amp;laquo; Previous">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    @for($x = $start; $x <= $limit; $x++)
                        @if($x == $books->currentPage())
                        <span aria-current="page">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                {{$x}}
                            </span>
                        </span>
                        @else
                            <a href="{{$books->url($x)}}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 1">
                                {{$x}}
                            </a>
                        @endif
                    @endfor

                    @if($books->onLastPage())
                        <span rel="prev" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 focus:z-10" aria-label="&amp;laquo; Previous">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <a href="{{$books->nextPageUrl()}}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next &amp;raquo;">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </span>
                </div>
            </div>
        @endif
    </div>
@endsection
