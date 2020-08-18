<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function readAll()
    {
        $authors = Author::orderBy('last_name', 'asc')
            ->get();
        return response()->json($authors);
    }

    public function readOne($id)
    {
        return response()->json(Author::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'pen_name' => 'nullable|max:255',
        ]);

        $author = Author::create($request->all());

        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {
        $author = Author::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete($id, Request $request)
    {
        Author::findOrFail($id)->delete();
        return response('Deleted successfully', 200);
    }
}
