@extends('template')

@section('content')
    <div class="flex flex-row justify-around mx-auto w-screen mt-8">
        <div class="flex flex-row gap-y-4 w-screen mx-8 items-start justify-between" style="height: calc(100vh - 6rem)">
            <div class="flex flex-col gap-y-4 p-8 w-full" style="height: 100%;">
                <div class="flex justify-between">
                    <h1 class="font-bold text-2xl">Purchase Invoice Number - {{$order->id}}</h1>
                        <div class="flex gap-4">
                            @if($order->status == "ordered")
                                <form action="/stock/update_status/" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="pid" value="{{$order->id}}">
                                    <input type="hidden" name="status" value="completed">
                                    <button class="text-green-600 hover:text-green-900 border py-2 px-4 rounded">Confirm Arrival</button>
                                </form>
                            @elseif($order->status == "not ordered")
                                <form action="/stock/update_status/" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="pid" value="{{$order->id}}">
                                    <input type="hidden" name="status" value="ordered">
                                    <button class="text-green-600 hover:text-green-900 border py-2 px-4 rounded">Order</button>
                                </form>
                            @endif
                        </div>
                </div>
                <hr>
                <h1 class="font-bold text-lg flex items-center gap-2">
                    Status :
                    @if($order->status == "completed")
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Completed
                        </span>
                    @elseif($order->status == "not ordered")
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Not ordered
                        </span>
                    @elseif($order->status == "ordered")
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
                    @foreach($books as $detail)
                        <div>
                            <img src="{{$detail->cover}}" alt="" width="64" height="64">
                        </div>
                        <div class="col-span-3">{{$detail->title}}</div>
                        <div class="col-span-1">
                            <span>$ </span>
                            <span>{{$detail->price}}</span>
                        </div>
                        <div class="col-span-1">{{$detail->quantity}}</div>
                        <div class="col-span-1">
                            <span>$ </span>
                            <span class="subtotals">{{$detail->price * $detail->quantity}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
