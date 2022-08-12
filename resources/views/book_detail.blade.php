@extends('template')

@section('content')
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 relative" role="alert" id="alertContainer">
            <strong class="font-bold">Holy smokes!</strong>
            <span class="block sm:inline">{{$errors->first()}}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500 cursor-pointer" id="close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>
    @endif
    <div class="flex flex-col mx-4 my-6">
        <div class="flex flex-row gap-4">
            <div class="flex justify-center">
                <img src="{{$book->cover}}" alt="" class="rounded p-3 rounded-xl">
            </div>
            <div class="flex flex-col gap-2 w-4/5 mr-8 justify-evenly">
                <div>
                    <h1 class="text-5xl font-medium">{{html_entity_decode($book->title)}}</h1>
                </div>
                <p class="break-all">{{$book->description}}</p>

                <div class="flex flex-col gap-y-4">
                    <h1 class="text-2xl">Detail</h1>
                    <div class="grid grid-cols-3">
                        <div class="flex flex-row gap-x-20 col-span-2">
                            <div class="flex flex-col gap-y-1">
                                <p class="text-sm text-gray-400">Written by</p>
                                <a href="" class="text-lg font-bold hover:underline">{{$book->author}}</a>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-sm text-gray-400">Published by</p>
                                <p class="text-lg font-bold">{{$book->publisher}}</p>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-sm text-gray-400">Year</p>
                                <p class="text-lg font-bold">{{substr($book->publication_date, 0, 4)}}</p>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-sm text-gray-400">Stock</p>
                                <p class="text-lg font-bold" id="stock">{{$book->stock}}</p>
                            </div>
                            <div class="flex flex-col gap-y-1">
                                <p class="text-sm text-gray-400">Genre</p>
                                <p class="text-lg font-bold" id="stock">{{$book->genre}}</p>
                            </div>
                        </div>
                        @if($book->stock == 0)
                            <div class="flex flex-row justify-end">
                                <div class="flex flex-row justify-center gap-x-6 items-center py-1 px-4 rounded bg-red-400 font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Out of Stock
                                </div>
                            </div>
                        @else
                            <div class="flex flex-row justify-end">
                                <div class="flex flex-row justify-center gap-x-6 items-center py-1 px-4 rounded bg-green-400 font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    In Stock
                                </div>
                            </div>
                        @endif
                    </div>
                    @if(auth()->check() && auth()->user()->role == "user" && $book->stock != 0)
                        <hr>
                        <form class="flex items-center justify-between select-none" action="/add_to_cart" method="post">
                            <h1 class="text-4xl font-bold" id="price">$ {{$book->price}}</h1>
                            <div class="gap-x-4 h-full flex flex-row">
                                <div class="grid grid-cols-3 h-full w-40 shadow-sm rounded-md border gap-x-4 place-items-center">
                                    <div class="cursor-pointer border-r rounded h-full w-full flex justify-center items-center hover:bg-gray-400" id="decrease">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                        </svg>
                                    </div>

                                    {{csrf_field()}}

                                    <span class="text-2xl" id="quantity">1</span>
                                    <input type="hidden" name="quantity" value="1" id="quantityInput">
                                    <input type="hidden" name="book_id" value="{{$book->id}}">

                                    <div class="cursor-pointer border-l rounded h-full w-full flex justify-center items-center hover:bg-gray-200" id="increase">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                </div>
                                <button class="flex flex-row justify-center gap-x-3 items-center py-1 px-4 rounded font-bold bg-green-400 hover:bg-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p>Add to Cart</p>
                                </button>
                            </div>
                        </form>
                    @elseif(auth()->check() && auth()->user()->role == "admin")
                        <hr>
                        <form class="flex items-center justify-between select-none" action="/stock/add" method="post">
                            {{csrf_field()}}
                            <h1 class="text-4xl font-bold" id="price">$ {{$book->price}}</h1>
                            <div class="gap-x-4 h-full flex flex-row">
                                <div class="grid grid-cols-3 h-full w-40 shadow-sm rounded-md border gap-x-4 place-items-center">
                                    <div class="cursor-pointer border-r rounded h-full w-full flex justify-center items-center hover:bg-gray-400" id="decrease">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                        </svg>
                                    </div>

                                    <span class="text-2xl" id="quantity">1</span>
                                    <input type="hidden" name="quantity" value="1" id="quantityInput">
                                    <input type="hidden" name="book_id" value="{{$book->id}}">

                                    <div class="cursor-pointer border-l rounded h-full w-full flex justify-center items-center hover:bg-gray-200" id="increaseStock">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                </div>
                                <button class="flex flex-row justify-center gap-x-3 items-center py-1 px-4 rounded font-bold bg-green-400 hover:bg-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p>Add Stock</p>
                                </button>
                            </div>
                        </form>
                    @endif


                </div>
            </div>
        </div>
        {{--Recommendation--}}
        <div class="flex justify-center flex-col items-center p-3">
            <h1 class="text-3xl text-left w-full font-bold">Recommendation</h1>
            <div class="mt-4 grid grid-cols-4 gap-2 2xl:grid-cols-7 w-full">
                @foreach($recommendation as $b)
                    <a class="item p-1.5 2xl:p-2 flex flex-col items-center justify-center rounded border gap-y-2 shadow text-start h-full" style="width: 200px;" href="/book/{{$b->id}}">
                        <img src="{{$b->cover}}" alt="" style="height: 200px" width="192.5">
                        @if(strlen($b->title) > 18)
                            <div class="w-full">{{substr($b->title, 0, 18)}}...</div>
                        @else
                            <div class="w-full">{{$b->title}}</div>
                        @endif
                        <h1 class="font-extrabold text-xl text-start w-full">$ {{$b->price}}</h1>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var increase = document.getElementById("increase")
        var decrease = document.getElementById("decrease")
        var qty = document.getElementById("quantity")
        var quantity_input = document.getElementById("quantityInput")
        var stock = parseInt(document.getElementById("stock").innerText)
        var increaseStock = document.getElementById("increaseStock")
        var decreaseStock = document.getElementById("decreaseStock")
        var quantityInput = document.getElementById("quantityInput")
        var close = document.getElementById("close")

        if (increase != null){
            increase.addEventListener('click', () => {
                if (parseInt(qty.innerHTML) + 1 <= stock){
                    qty.innerHTML = parseInt(qty.innerHTML) + 1
                    quantity_input['value'] = qty.innerText
                }
            })
        }

        if (decrease != null){
            decrease.addEventListener('click', () => {
                if (qty.innerText !== "1"){
                    qty.innerHTML = parseInt(qty.innerHTML) - 1
                    quantity_input['value'] = qty.innerText
                }
            })
        }

        if (increaseStock != null){
            increaseStock.addEventListener('click', () => {
                qty.innerHTML = parseInt(qty.innerHTML) + 1
                quantity_input['value'] = qty.innerText
            })
        }

        if (close != null){
            close.addEventListener('click', () => {
                document.getElementById("alertContainer").remove()
            })
        }

    </script>
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
