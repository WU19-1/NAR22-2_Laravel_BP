<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eli's Book Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#ab9370',
                        'primary-dark': '#ddc39f',
                        'primary-light': '#7b6544',
                        'secondary': '#212121',
                        'secondary-light': '#484848',
                        'secondary-dark': '#000000'
                    }
                }
            }
        }
    </script>
    <style>
        #cart-container:hover #cart-svg {
            stroke: white;
        }
        *::-webkit-scrollbar{
            display: none;
        }
    </style>
</head>
<body>
    <nav class="h-16 bg-primary flex flex-row justify-between items-center px-4">
        <div class="my-auto"><a href="/" class="text-xl font-extrabold">Eli's Book Store</a></div>
        {{--        <div class="flex flex-col items-center my-auto w-1/3">--}}
        {{--            <input type="text" name="Search" class="rounded w-full py-1" placeholder="Search book">--}}
        {{--        </div>--}}
        <label class="relative block w-1/3">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 fill-black" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30"
                         height="30" viewBox="0 0 30 30">
                        <path
                            d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z">
                        </path>
                    </svg>
                </span>
            <form action="/search" method="get">
                <input
                    class="w-full bg-white placeholder:font-italic border border-slate-300 rounded-full py-2 pl-10 pr-4 focus:outline-none"
                    placeholder="Search book" type="text" name="q" />
            </form>
        </label>
        <div class="flex flex-row items-center my-auto gap-x-4 text-lg font-bold">
            @if(auth()->check())
                <a id="cart-container" href="/cart" class="p-2 hover:rounded-lg hover:bg-secondary hover:stroke-white">
                    <svg id="cart-svg" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
                <a href="/about_us" class="p-2 hover:rounded-lg hover:bg-secondary hover:text-white">About us</a>
                <form action="/logout" method="POST" class="h-full p-2 hover:rounded-lg hover:bg-secondary hover:text-white">
                    {{csrf_field()}}
                    <button>Logout</button>
                </form>
            @else
                <a href="/login" class="p-2 hover:rounded-lg hover:bg-secondary hover:text-white">Login</a>
            @endif
        </div>
    </nav>
    @yield('content')
</body>
@yield('script')
</html>
