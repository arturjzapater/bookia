<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function readAll()
    {
        return response()->json(Author::all());
    }

    public function readOne($id)
    {
        return response()->json(Author::find($id));
    }

    public function create(Request $request)
    {
        $book = Author::create($request->all());

        return response()->json($book, 201);
    }

    public function update($id, Request $request)
    {
        $book = Author::findOrFail($id);
        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function delete($id, Request $request)
    {
        Author::findOrFail($id)->delete();
        return response('Deleted successfully', 200);
    }
}
