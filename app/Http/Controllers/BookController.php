<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function readAll()
    {
        return response()->json(Book::all());
    }

    public function readOne($id)
    {
        return response()->json(Book::find($id));
    }

    public function create(Request $request)
    {
        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function update($id, Request $request)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function delete($id, Request $request)
    {
        Book::findOrFail($id)->delete();
        return response('Deleted successfully', 200);
    }
}
