@extends('template')

@section('content')
    <div class="flex flex-row justify-around mx-auto w-screen mt-8">
        <div class="flex flex-row gap-y-4 w-screen mx-8 items-start justify-between" style="height: calc(100vh - 6rem)">
            <div class="flex flex-col gap-y-2 w-full h-full">
                <div class="flex flex-row gap-4 items-center">
                    <h1 class="font-bold text-2xl">Transaction History</h1>
                    <a href="/order" class="py-1 px-2 border rounded-full
                        @if(request()->status == null)
                            bg-secondary text-white
                        @endif
                        ">All</a>
                    <a href="?status=completed" class="py-1 px-2 border rounded-full
                        @if(request()->status == "completed")
                            bg-secondary text-white
                        @endif
                    ">Completed</a>
                    <a href="?status=pending" class="py-1 px-2 border rounded-full
                        @if(request()->status == "pending" && request()->status != null)
                            bg-secondary text-white
                        @endif
                    ">Pending</a>
                    <a href="?status=rejected" class="py-1 px-2 border rounded-full
                        @if(request()->status == "rejected" && request()->status != null)
                            bg-secondary text-white
                        @endif
                    ">Rejected</a>
                </div>
                <table class="min-w-full divide-y divide-gray-200 border rounded-lg mt-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Invoice ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Transaction Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Items
                            </th>
                            @if(auth()->user()->role == "admin")
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Checked By
                                </th>
                            @endif
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 rounded">
                        @foreach($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{$transaction->id}}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$transaction->transaction_date}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->status == "completed")
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @elseif($transaction->status == "pending payment")
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Pending Payment
                                        </span>
                                    @elseif($transaction->status == "rejected")
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @elseif($transaction->status == "pending check")
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                            Pending Check
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{$transaction->total_items}} item(s)
                                </td>
                                @if(auth()->user()->role == "admin")
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{auth()->user()->name}}
                                    </td>
                                @endif
                                <td class="flex gap-4 px-6 py-4 whitespace-nowrap text-middle text-sm font-medium">
                                    <a
                                        class="text-indigo-600 hover:text-indigo-900 border py-2 px-4 rounded"
                                        href="/order/{{$transaction->id}}"
                                    >
                                        Details
                                    </a>
                                    @if($transaction->proof != "")
                                        <a
                                            class="text-indigo-600 hover:text-indigo-900 border py-2 px-4 rounded"
                                            href="/storage/{{$transaction->proof}}"
                                            target="_blank"
                                        >
                                            Proof
                                        </a>
                                        @else
                                        <a
                                            class="text-indigo-600 hover:text-gray-900 border py-2 px-4 rounded text-white bg-gray-300 cursor-not-allowed"
                                            target="_blank"
                                        >
                                            Proof
                                        </a>
                                    @endif
                                    @can('see-admin-feature')
                                        @if($transaction->proof != "")
                                        <form action="/order/approve" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="tid" value="{{$transaction->id}}">
                                            <button class="text-green-600 hover:text-green-900 border py-2 px-4 rounded">Approve</button>
                                        </form>
                                        <form action="/order/reject" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="tid" value="{{$transaction->id}}">
                                            <button class="text-red-600 hover:text-red-900 border py-2 px-4 rounded">Reject</button>
                                        </form>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($transactions->total() > 12)
                    @php
                        $paginator = $transactions->links()->elements;
                    @endphp
                    <div class="pagination p-4 flex justify-center items-center">
                        <div class="">
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            @if($transactions->onFirstPage())
                                <span rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 focus:z-10" aria-label="&amp;laquo; Previous">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{$transactions->previousPageUrl()}}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="&amp;laquo; Previous">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            @foreach($paginator as $item)
                                @if(is_array($item))
                                    @foreach(array_keys($item) as $page)
                                        @if($item[$page] == $transactions->url($transactions->currentPage()))
                                            <span aria-current="page">
                                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                                    {{$page}}
                                                </span>
                                            </span>
                                        @else
                                            <a href="{{$transactions->url($page)}}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page 1">
                                                {{$page}}
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                                            {{$item}}
                                        </span>
                                    </span>
                                @endif

                            @endforeach

                            @if($transactions->onLastPage())
                                <span rel="prev" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 focus:z-10" aria-label="&amp;laquo; Previous">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{$transactions->nextPageUrl()}}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next &amp;raquo;">
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
        </div>
    </div>
@endsection
