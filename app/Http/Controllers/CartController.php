<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(){
        return view('cart');
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [

        ]);


        if ($validator->fails()){
            return redirect('/register')->withErrors($validator->errors());
        }
    }


}
