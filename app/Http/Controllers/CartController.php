<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(){
        $items = Cart::with('book')->where('user_id', '=', auth()->user()->id)->get();
        return view('cart', compact('items'));
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        Cart::create([
            'user_id' => auth()->user()->id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity
        ]);

        return redirect()->back();
    }

    public function delete(Request $request){
        $x = Cart::where('user_id', '=', auth()->user()->id)
            ->where('book_id', '=', $request->book_id)->delete();
        return redirect()->back();
    }

}
