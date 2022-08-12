<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index($id){
        $datas = TransactionHeader::find($id);
        $total = $datas->details()
            ->join('books', 'books.id', '=', 'book_id')
            ->sum(DB::raw('books.price * quantity'));
        return view('order_payment', compact('datas', 'total', 'id'));
    }

    public function upload(Request $request){
        Validator::validate($request->all(), [
            'proof' => 'required|mimes:png,jpg,jpeg',
            'tid' => 'required'
        ], [
            'proof.required' => 'You need to upload a proof image that you\'ve paid!',
            'tid.required' => 'Something went wrong, please try again !'
        ]);
        $file = $request->file('proof');
        $filename = $request->tid . "." . $file->extension();
        $file->move(public_path('storage'), $filename);
        $transaction = TransactionHeader::find($request->tid)->first();
        $transaction->status = "pending check";
        $transaction->proof = $filename;
        $transaction->save();
        return redirect('/order');
    }

    public function list(Request $request){
        $transactions = TransactionHeader::join('transaction_details', 'transaction_details.transaction_id', '=', 'transaction_headers.id')
//            ->join('books', 'books.id', '=', 'transaction_details.book_id')
            ->select('id', 'user_id','transaction_date', 'status', 'proof', DB::raw('COUNT(*) as total_items'))
            ->groupBy('id', 'user_id', 'transaction_date', 'status', 'proof')
            ->orderBy('transaction_date', 'DESC');
        if (auth()->user()->role != "admin"){
            $transactions = $transactions->where('user_id', '=', auth()->user()->id);
        }
        if ($request->status == null){
            $transactions = $transactions->paginate(12);
        } else if ($request->status == 'pending'){
            $transactions = $transactions->where('status', 'LIKE', $request->status . '%')->paginate(12);
        } else {
            $transactions = $transactions->where('status', '=', $request->status)->paginate(12);
        }
        $transactions->appends('status', $request->status);
        return view('order', compact('transactions'));
    }

    public function accept(Request $request){
        $transaction = TransactionHeader::find($request->tid);
        if ($transaction == null) abort(404);
        $transaction->status = 'completed';
        $transaction->checked_by = auth()->user()->id;
        $transaction->checked_at = DB::raw('NOW()');
        $transaction->save();

        foreach($transaction->details as $detail){
            $book = Book::find($detail->book_id);
            $book->stock -= $detail->quantity;
            $book->save();
        }

        return redirect()->back();
    }

    public function reject(Request $request){
        $transaction = TransactionHeader::find($request->tid);
        if ($transaction == null) abort(404);
        Storage::disk('public')->delete($transaction->proof);
        $transaction->status = 'rejected';
        $transaction->proof = '';
        $transaction->checked_at = DB::raw('NOW()');
        $transaction->save();
        return redirect()->back();
    }
}
