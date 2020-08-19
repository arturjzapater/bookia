<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private function addAuthorInfo($book)
    {
        $book->author = $book->author()
            ->select('id', 'first_name', 'last_name', 'pen_name')
            ->first();
        $book->author->url = '/api/authors/' . $book->author->id;
        return $book;
    }

    public function readAll()
    {
        $books = Book::orderBy('title', 'asc')
            ->get()
            ->map(function ($book) {
                return $this->addAuthorInfo($book);
            });
        return response()->json($books);
    }

    public function readOne($id)
    {
        $book = Book::find($id);
        $result = $this->addAuthorInfo($book);
        return response()->json($result);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'date_published' => 'required|date',
            'author_id' => 'required',
        ]);


        $book = Book::create($request->all());
        $result = $this->addAuthorInfo($book);

        return response()
            ->json($result, 201)
            ->header('Location', '/api/books/' . $result->id);
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
