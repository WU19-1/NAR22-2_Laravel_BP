<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PurchaseHeader;
use App\Models\TransactionHeader;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(){
        $books = Book::paginate(36);
        return view('home', compact('books'));
    }

    public function detail(Request  $request, $id){
        $book = Book::find($id);
        $recommendation = [];

        $total = Book::count();

        while(count($recommendation) != 28){
            $b = Book::find(rand(1, $total));
            if (!in_array($b, $recommendation) && $b != null)
                array_push($recommendation, $b);
        }

        return view('book_detail', compact('book', 'recommendation'));
    }

    public function search(Request $request){
        $books = Book::where('title', 'LIKE', "%$request->q%")->paginate(36);
        $books->appends('q', $request->q);
        return view('home', compact('books'));
    }

    public function add_book_index(){
        return view('add_book');
    }

    public function store_book(Request $request){
        $client = new Client(['http_errors' => false]);
        $res = $client->post(env('API_URL') . 'book/create', [
            RequestOptions::JSON => $request->all(),
            'headers' => [
                'Authorization' => 'Bearer ' . env('API_TOKEN')
            ]
        ]);

        if ($res->getStatusCode() == 200){
            Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'language' => $request->language,
                'cover' => $request->cover,
                'genre' => $request->genre,
                'publication_date' => $request->publication_date,
                'publisher' => $request->publisher,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => 0
            ]);
            return redirect()->back();
        } else {
            return back()->withInput()->withErrors(json_decode($res->getBody())->message);
        }

    }

}
