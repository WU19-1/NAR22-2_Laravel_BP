<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PurchaseDetail;
use App\Models\PurchaseHeader;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request){
//        $orders = PurchaseHeader::join('purchase_details', 'purchase_headers.id', '=', 'purchase_details.purchase_id')
//            ->orderBy('transaction_date','desc')
//            ->groupBy('transaction_date', 'status', 'id')
//            ->select(DB::raw('count(*) AS total_items'), 'transaction_date', 'status', 'id');
//
//        if ($request->status == 'completed')
//            $orders = $orders->where('status', '=', 'completed');
//        else if ($request->status == 'ordered')
//            $orders = $orders->where('status', '=', 'ordered');
//        else if ($request->status == 'not ordered')
//            $orders = $orders->where('status', '=', 'not ordered');
//        $orders = $orders->paginate(8);
        $client = new Client();
        $res = $client->get(env('API_URL') . 'transaction?total=8&page=' . ($request->page == null ? '' : $request->page) . '&status=' .
            ($request->status == null ? 'all' : $request->status), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('API_TOKEN')
            ]
        ]);
        $orders = json_decode($res->getBody());
        return view('stock_order', compact('orders'));
    }

    public function add_stock_request(Request $request){
//        $transaction = PurchaseHeader::where('status', '=', 'not ordered')
//            ->orderBy('id', 'desc')
//            ->first();
//        if ($transaction == null){
//            $transaction = PurchaseHeader::create([
//                'staff_id' => auth()->user()->id,
//                'transaction_date' => DB::raw('NOW()'),
//                'arrived_at' => DB::raw('NULL'),
//                'status' => 'not ordered'
//            ]);
//        }
//        PurchaseDetail::create([
//            'purchase_id' => $transaction->id,
//            'book_id' => $request->book_id,
//            'quantity' => $request->quantity
//        ]);
        $client = new Client();
        $res = $client->post(env('API_URL') . 'transaction/add_order', [
            RequestOptions::JSON => [
                'book_id' => $request->book_id,
                'quantity' => $request->quantity
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . env('API_TOKEN')
            ]
        ]);
        if ($res->getStatusCode() == 200)
            return redirect()->back()->with(['success', 'successfully add order']);
        else
            return redirect()->back()->withErrors(['message', json_decode($res->getBody())->message]);
    }

    public function show($id){
//        $order = PurchaseHeader::find($id);
        $client = new Client();
        $res = $client->get(env('API_URL') . 'transaction/' . $id, [
            'headers' => [
                'Authorization' => 'Bearer ' . env('API_TOKEN')
            ]
        ]);
        $data = json_decode($res->getBody());
        if ($res->getStatusCode() == 200)
            return view('stock_detail', ['order' => $data->order, 'books' => $data->books]);
        else
            abort(404);
    }

    public function update_status(Request $request){
//        $order = PurchaseHeader::find($request->pid);
//        $order->status = $request->status;
//        $order->save();
//        if ($request->status == "ordered"){
//            $client = new Client();
//            foreach($order->details as $detail){
//                $res = $client->post(env('API_URL') . 'transaction/add_order', [
//                    RequestOptions::JSON => [
//                        'book_id' => $detail->book_id,
//                        'quantity' => $detail->quantity
//                    ],
//                    'headers' => [
//                        'Authorization' => 'Bearer ' . env('API_TOKEN')
//                    ]
//                ]);
//            }
//            $client->patch(env('API_URL') . 'transaction/update_status/' . ((string) json_decode($res->getBody())->id), [
//                RequestOptions::JSON => [
//                    'status' => 'ordered',
//                ],
//                'headers' => [
//                    'Authorization' => 'Bearer ' . env('API_TOKEN')
//                ]
//            ]);
//        }
        $client = new Client();
        $res = $client->patch(env('API_URL') . 'transaction/update_status/' . $request->pid, [
            RequestOptions::JSON => [
                'status' => $request->status
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . env('API_TOKEN')
            ]
        ]);

        //TODO: validate 200, 204, 400, 404
        if ($res->getStatusCode() == 400){

        } else if ($res->getStatusCode() == 404){

        }

        if ($request->status == 'completed'){
            $res_add = $client->get(env('API_URL') . 'transaction/' . $request->pid, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('API_TOKEN')
                ]
            ]);
            $data = json_decode($res_add->getBody());
            if ($res_add->getStatusCode() == 200){
                foreach ($data->books as $book){
                    $b = Book::find($book->id);
                    if ($b != null){
                        $b->stock += $book->quantity;
                        $b->save();
                    }
                }
            }
        }

        return redirect()->back();
    }

}
