<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request){
        $books = Book::paginate(36);
        return view('home', compact('books'));
    }

    public function detail(Request  $request, $id){
        $book = Book::find($id);
        $recommendation = [];

        $total = Book::count();

        while(count($recommendation) != 28){
            $b = Book::find(rand(1, $total));
            if (!in_array($b, $recommendation))
                array_push($recommendation, $b);
        }

        return view('book_detail', compact('book', 'recommendation'));
    }

    public function search(Request $request){
        $books = Book::where('title', 'LIKE', "%$request->q%")->paginate(36);
        $books->appends('q', $request->q);
        return view('home', compact('books'));
    }


}
