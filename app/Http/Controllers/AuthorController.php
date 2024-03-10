<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    // Metoda do pobierania wszystkich autorów
    public function getAllAuthors()
    {
        $authors = Author::all();
        return response()->json($authors);
    }

    // Metoda do dodawania nowego autora
    public function addAuthor(Request $request)
    {
        // Walidacja danych wejściowych
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        // Utworzenie nowego autora
        $author = new Author([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);
        $author->save();

        return response()->json('Author created successfully');
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        // Utworzenie nowego autora
        $author = new Author();
        $author->first_name = $request->first_name;
        $author->last_name = $request->last_name;
        $author->save();

        // Przekierowanie użytkownika po dodaniu autora
        return redirect()->route('authors.create')->with('success', 'Autor dodany pomyślnie.');
    }

}