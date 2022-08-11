@extends('template')

@section('content')
    <div class="flex m-auto justify-center items-center w-2/3">
        <form class="m-4 bg-white flex justify-center gap-4 p-8 flex-col" action="" method="post">
            <h1 class="text-2xl font-bold">Add new book</h1>
            {{csrf_field()}}
            <p class="font-bold">Title</p>
            <input type="text" name="title" class="p-2 border-black border-2 rounded">
            <p class="font-bold">Author</p>
            <input type="text" name="author" class="p-2 border-black border-2 rounded">
            <p class="font-bold">Cover</p>
            <input type="text" name="cover" class="p-2 border-black border-2 rounded">
            <p class="font-bold">Language</p>
            <input type="text" name="language" class="p-2 border-black border-2 rounded">

            <div class="flex items-center gap-4 w-full">
                <div class="flex flex-col w-1/4">
                    <p class="font-bold">Price</p>
                    <input type="number" name="price" class="p-2 border-black border-2 rounded">
                </div>
                <div class="flex flex-col w-1/4">
                    <p class="font-bold">Genre</p>
                    <input type="text" name="genre" class="p-2 border-black border-2 rounded">
                </div>
                <div class="flex flex-col w-1/4">
                    <p class="font-bold">Publication Date</p>
                    <input type="text" name="publication_date" class="p-2 border-black border-2 rounded">
                </div>
                <div class="flex flex-col w-1/4">
                    <p class="font-bold">Publisher</p>
                    <input type="text" name="publisher" class="p-2 border-black border-2 rounded">
                </div>
            </div>
            <p class="font-bold">Description</p>
            <textarea type="text" name="description" class="p-2 border-black border-2 rounded"></textarea>
            <hr>
            @if($errors->any())
                <div class="font-bold text-red-600">{{$errors->first()}}</div>
            @endif
            <button class="p-2 rounded bg-primary hover:bg-primary-light hover:text-white font-bold">Add Book</button>
        </form>
    </div>
@endsection

