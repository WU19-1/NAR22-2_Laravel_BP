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
    <div class="flex flex-row justify-around mx-auto w-screen mt-8">
        <div class="flex flex-row gap-y-4 w-screen mx-8 items-start justify-between" style="height: calc(100vh - 6rem)">
            <div class="flex flex-col gap-y-4 p-8 w-full" style="height: 100%;">
                @if(auth()->user()->role == "user")
                    <div class="grid grid-cols-2 gap-8">
                        <div class="flex flex-col gap-y-2">
                            <hr>
                            <h1 class="font-bold text-2xl">Payment Method</h1>
                            <hr>
                            <div class="grid grid-cols-2 text-lg gap-y-2">
                                <p>Transfer to</p>
                                <p class="text-right">0xC257274276a4E539741Ca11b590B9447B26A8051</p>
                                <p>Network</p>
                                <div class="flex items-center gap-2 justify-end"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 336.41 337.42"><defs><style>.cls-1{fill:#f0b90b;stroke:#f0b90b;}</style></defs><title>Asset 1</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M168.2.71l41.5,42.5L105.2,147.71l-41.5-41.5Z"/><path class="cls-1" d="M231.2,63.71l41.5,42.5L105.2,273.71l-41.5-41.5Z"/><path class="cls-1" d="M42.2,126.71l41.5,42.5-41.5,41.5L.7,169.21Z"/><path class="cls-1" d="M294.2,126.71l41.5,42.5L168.2,336.71l-41.5-41.5Z"/></g></g></svg> Binance Smart Chain</div>
                                <p>Coin</p>
                                <div class="flex items-center gap-2 justify-end"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 339.43 295.27"><title>tether-usdt-logo</title><path d="M62.15,1.45l-61.89,130a2.52,2.52,0,0,0,.54,2.94L167.95,294.56a2.55,2.55,0,0,0,3.53,0L338.63,134.4a2.52,2.52,0,0,0,.54-2.94l-61.89-130A2.5,2.5,0,0,0,275,0H64.45a2.5,2.5,0,0,0-2.3,1.45h0Z" style="fill:#50af95;fill-rule:evenodd"/><path d="M191.19,144.8v0c-1.2.09-7.4,0.46-21.23,0.46-11,0-18.81-.33-21.55-0.46v0c-42.51-1.87-74.24-9.27-74.24-18.13s31.73-16.25,74.24-18.15v28.91c2.78,0.2,10.74.67,21.74,0.67,13.2,0,19.81-.55,21-0.66v-28.9c42.42,1.89,74.08,9.29,74.08,18.13s-31.65,16.24-74.08,18.12h0Zm0-39.25V79.68h59.2V40.23H89.21V79.68H148.4v25.86c-48.11,2.21-84.29,11.74-84.29,23.16s36.18,20.94,84.29,23.16v82.9h42.78V151.83c48-2.21,84.12-11.73,84.12-23.14s-36.09-20.93-84.12-23.15h0Zm0,0h0Z" style="fill:#fff;fill-rule:evenodd"/></svg> USDT</div>
                                <p>Total</p>
                                <p class="text-right">$ {{$total}}</p>
                            </div>
                        </div>

                        <form class="w-full h-full gap-y-4 flex flex-col" action="/order/upload_proof" method="post" enctype="multipart/form-data">
                            <label
                                class="flex justify-center w-full h-full px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                                <span class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <span class="font-medium text-gray-600">
                                        Drop image files
                                        <span class="text-blue-600 underline">browse</span>
                                    </span>
                                </span>
                                <input type="file" name="proof" class="hidden" accept="image/png, image/jpg, image/jpeg">
                            </label>
                            {{csrf_field()}}
                            <input type="hidden" name="tid" value="{{$id}}">
                            <button class="p-3 w-full rounded-lg bg-primary hover:bg-primary-light hover:stroke-white hover:text-white">Upload Payment Proof</button>
                        </form>
                    </div>
                @endif
                <hr>
                <div class="flex justify-between">
                    <h1 class="font-bold text-2xl">Invoice - {{$id}}</h1>
                    <div class="flex gap-4">
                        <a
                            class="text-indigo-600 hover:text-gray-900 border py-2 px-4 rounded
                            @if($datas->proof != "")
                                "
                                href="/storage/{{$datas->proof}}"
                                target="_blank"
                            @else
                                text-white bg-gray-300 cursor-not-allowed"
                            @endif
                        >
                            Proof
                        </a>
                        @if($datas->proof != "" and auth()->user()->role == "admin")
                            <form action="/order/approve" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="tid" value="{{$id}}">
                                <button class="text-green-600 hover:text-green-900 border py-2 px-4 rounded">Approve</button>
                            </form>
                            <form action="/order/reject" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="tid" value="{{$id}}">
                                <button class="text-red-600 hover:text-red-900 border py-2 px-4 rounded">Decline</button>
                            </form>
                        @endif
                    </div>
                </div>
                <hr>
                <h1 class="font-bold text-lg flex items-center gap-2">
                    Status :
                    @if($datas->status == "completed")
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Completed
                        </span>
                    @elseif($datas->status == "pending payment")
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Pending Payment
                        </span>
                    @elseif($datas->status == "rejected")
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Rejected
                        </span>
                    @elseif($datas->status == "pending check")
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                            Pending Check
                        </span>
                    @endif
                </h1>
                <hr>
                <div class="grid grid-cols-7 items-center">
                    <div class="col-span-1"></div>
                    <div class="col-span-3">Name</div>
                    <div class="col-span-1">Price</div>
                    <div class="col-span-1">Quantity</div>
                    <div class="col-span-1">Subtotal</div>
                </div>
                <hr>
                <div class="grid grid-cols-7 gap-y-4 auto-rows-min overflow-auto items-center justify-center" style="height: 100%;">
                    @foreach($datas->details as $detail)
                        <div>
                            <img src="{{$detail->book->cover}}" alt="" width="64" height="64">
                        </div>
                        <div class="col-span-3">{{$detail->book->title}}</div>
                        <div class="col-span-1">
                            <span>$ </span>
                            <span>{{$detail->book->price}}</span>
                        </div>
                        <div class="col-span-1">{{$detail->quantity}}</div>
                        <div class="col-span-1">
                            <span>$ </span>
                            <span class="subtotals">{{$detail->book->price * $detail->quantity}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById("close").addEventListener('click', () => {
            document.getElementById("alertContainer").remove()
        })
    </script>
@endsection
