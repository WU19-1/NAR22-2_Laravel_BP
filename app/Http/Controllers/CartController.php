<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(){
        $items = Cart::with('book')->where('user_id', '=', auth()->user()->id)->get();
        foreach($items as $item){
            $item->input_id = Str::uuid();
        }
        return view('cart', compact('items'));
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|numeric',
            'quantity' => 'required|numeric|gte:1',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $book_stock = Book::find($request->book_id)->stock;

        if($request->quantity > $book_stock){
            return redirect()->back()->withErrors("Book doesn't have enough stock");
        }

        $cart = Cart::where('user_id', '=', auth()->user()->id)
            ->where('book_id', '=', $request->book_id)->first();

        if ($cart != null){
            if ($cart->quantity + $request->quantity <= $book_stock){
//                $cart->quantity += $request->quantity;
                Cart::where('user_id', '=', auth()->user()->id)
                    ->where('book_id', '=', $request->book_id)->update(['quantity' => $cart->quantity + $request->quantity]);
            } else {
                return redirect()->back()->withErrors("Book doesn't have enough stock");
            }
        } else {
            Cart::create([
                'user_id' => auth()->user()->id,
                'book_id' => $request->book_id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back();
    }

    public function delete(Request $request){
        Cart::where('user_id', '=', auth()->user()->id)
            ->where('book_id', '=', $request->book_id)->delete();
        return redirect()->back();
    }

    public function checkout(Request $request){
        $temp = array_values($request->all());
        for($i = 1; $i < count($temp); $i++){
            $arr = explode(":", $temp[$i]);
            $book = Book::find($arr[0]);
            $qty = $arr[1];
            if ($book->stock < $qty){
                return redirect()->back()->withErrors(['Book with title "' . $book->title . '" does not have enough stock!']);
            } else if ($qty == 0){
                return redirect()->back()->withErrors(['Cannot order book with 0 quantity']);
            }
        }
        $uuid = (string) Str::uuid();
        while(TransactionHeader::find($uuid) != null){
            $uuid = (string) Str::uuid();
        }
        TransactionHeader::create([
            'id' => $uuid,
            'user_id' => auth()->user()->id,
            'transaction_date' => DB::raw('NOW()'),
            'status' => 'pending payment',
            'proof' => '',
            'checked_by' => DB::raw('NULL'),
            'checked_at' => DB::raw('NULL')
        ]);
        for($i = 1; $i < count($temp); $i++){
            $arr = explode(":", $temp[$i]);
            $book_id = $arr[0];
            $qty = $arr[1];
            TransactionDetail::create([
                'transaction_id' => $uuid,
                'book_id' => $book_id,
                'quantity' => $qty
            ]);
        }
        Cart::where('user_id', '=', auth()->user()->id)->delete();
        return redirect('/order/' . $uuid);
    }

}
