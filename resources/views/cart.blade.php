@extends('template')

@section('content')
    <div class="flex flex-row justify-around mx-auto w-screen mt-8">
        <div class="flex flex-row gap-y-4 w-screen mx-8 items-center" style="height: calc(100vh - 6rem)">
            <div class="flex flex-col gap-y-4 w-4/6 p-8" style="height: 100%;">
                <hr>
                <h1 class="font-bold text-2xl">Shopping Cart</h1>
                <hr>
                <div class="grid grid-cols-8 items-center">
                    <div class="col-span-1"></div>
                    <div class="col-span-1"></div>
                    <div class="col-span-3">Name</div>
                    <div class="col-span-1">Price</div>
                    <div class="col-span-1">Quantity</div>
                    <div class="col-span-1">Subtotal</div>
                </div>
                <hr>
                <div class="grid grid-cols-8 gap-y-4 overflow-auto items-center justify-center" style="height: 100%;">
                    {{-- Data --}}
                    @for($i = 0; $i < 6; $i++)
                        <form action="" method="post">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#ff0000" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                        <div>
                            <img src="https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1449868701l/11127._SY475_.jpg" alt=""
                            width="64" height="64">
                        </div>
                        <div class="col-span-3">The Chronicles of Narnia Here</div>
                        <div class="col-span-1">$ 10</div>
                        <div class="col-span-1"><input type="number" value="15" class="w-1/2 p-2 border rounded"></div>
                        <div class="col-span-1">$ 150</div>
                    @endfor

                </div>
            </div>
            <div class="w-2/6 p-8 border shadow rounded h-fit flex flex-col gap-y-4">
                <div class="flex flex-row justify-between items-center">
                    <h1 class="font-bold text-xl">Grand Total</h1>
                    <h1 class="text-lg">$ 123</h1>
                </div>
                <hr>
                <form action="" method="post">
                    <button class=" p-4 w-full rounded-lg bg-primary hover:bg-primary-light hover:stroke-white hover:text-white">Proceed to checkout</button>
                </form>
            </div>

        </div>
    </div>
@endsection
