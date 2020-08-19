<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    private function addBooks($author)
    {
        $author->books = $author->books()
            ->select('id', 'title', 'date_published')
            ->get()
            ->map(function($book) {
                $book->url = '/api/books/' . $book->id;
                return $book;
            });
            return $author;
    }

    public function readAll()
    {
        $authors = Author::orderBy('last_name', 'asc')
            ->get();
        return response()->json($authors);
    }

    public function readOne($id)
    {
        $author = Author::find($id);
        $result = $this->addBooks($author);
        return response()->json($result);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'pen_name' => 'nullable|max:255',
        ]);

        $author = Author::create($request->all());

        return response()
            ->json($author, 201)
            ->header('Location', '/api/authors/' . $author->id);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
            'pen_name' => 'nullable|max:255',
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete($id, Request $request)
    {
        Author::findOrFail($id)->delete();
        return response()->json([ 'message' => 'Deleted succesfully' ], 200);
    }
}
