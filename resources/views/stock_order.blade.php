@extends('template')

@section('content')
    <div class="flex flex-row justify-around mx-auto w-screen mt-8">
        <div class="flex flex-row gap-y-4 w-screen mx-8 items-start justify-between" style="height: calc(100vh - 6rem)">
            <div class="flex flex-col gap-y-2 w-full h-full">
                <div class="flex flex-row gap-4 items-center">
                    <h1 class="font-bold text-2xl">Purchase History</h1>
                    <a href="/stock/order" class="py-1 px-2 border rounded-full
                        @if(request()->status == null)
                            bg-secondary text-white
                        @endif
                        ">All
                    </a>
                    <a href="?status=completed" class="py-1 px-2 border rounded-full
                        @if(request()->status == "completed")
                            bg-secondary text-white
                        @endif
                        ">Completed
                    </a>
                    <a href="?status=ordered" class="py-1 px-2 border rounded-full
                        @if(request()->status == "ordered" && request()->status != null)
                            bg-secondary text-white
                        @endif
                        ">Ordered
                    </a>
                    <a href="?status=not ordered" class="py-1 px-2 border rounded-full
                        @if(request()->status == "not ordered" && request()->status != null)
                        bg-secondary text-white
                        @endif
                        ">Not Ordered
                    </a>
                </div>
                <table class="min-w-full divide-y divide-gray-200 border rounded-lg mt-4">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Transaction Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Items
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 rounded">
                        @foreach($orders->data as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$order->transaction_date}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($order->status == "completed")
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @elseif($order->status == "not ordered")
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Not Ordered
                                        </span>
                                    @elseif($order->status == "ordered")
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                            Ordered
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{$order->total_items}} item(s)
                                </td>
                                <td class="flex gap-4 px-6 py-4 whitespace-nowrap text-middle text-sm font-medium">
                                    <a class="text-indigo-600 hover:text-indigo-900 border py-2 px-4 rounded" href="/stock/{{$order->id}}">
                                        Details
                                    </a>
                                    @if($order->status == 'ordered')
                                        <form
                                            action="/stock/update_status/"
                                            method="post"
                                        >
                                            {{csrf_field()}}
                                            <input type="hidden" name="pid" value="{{$order->id}}">
                                            <input type="hidden" name="status" value="completed">
                                            <button class="text-green-600 hover:text-green-900 border py-2 px-4 rounded">
                                                Confirm Arrival
                                            </button>
                                        </form>
                                    @elseif($order->status == 'not ordered')
                                        <form
                                            action="/stock/update_status/"
                                            method="post"
                                        >
                                            {{csrf_field()}}
                                            <input type="hidden" name="pid" value="{{$order->id}}">
                                            <input type="hidden" name="status" value="ordered">
                                            <button class="text-green-600 hover:text-green-900 border py-2 px-4 rounded">
                                                Order
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
{{--                <div>--}}
{{--                    {{$orders->links()}}--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
