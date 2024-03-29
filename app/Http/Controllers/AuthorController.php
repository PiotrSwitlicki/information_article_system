<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\View\View;

class AuthorController extends Controller
{
    protected $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    // Metoda do pobierania wszystkich autorów
    public function index()
    {
        $authors = $this->author->all();
        return response()->json($authors);
    }

    // Metoda do dodawania nowego autora
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ], [
            'first_name.required' => 'Pole imię jest wymagane.',
            'last_name.required' => 'Pole nazwisko jest wymagane.',
        ]);

        // Sprawdzenie czy autor o podanej kombinacji imienia i nazwiska już istnieje
        $existingAuthor = Author::where('first_name', $request->first_name)
                                ->where('last_name', $request->last_name)
                                ->first();
        //Wyświetlenie komunikatu, że autor jest już w bazie
        if ($existingAuthor != null) {
            return redirect()->back()->with('error', 'Autor o podanej kombinacji imienia i nazwiska już istnieje.');
        }

        // Jeśli autor nie istnieje, dodajemy go do bazy danych
        $author = new Author();
        $author->first_name = $request->first_name;
        $author->last_name = $request->last_name;
        $author->save();

        return redirect()->route('authors.create')->with('success', 'Autor dodany pomyślnie.');
    }

    // Metoda do wyświetlania formularza dodawania autora
    public function create()
    {
        return view('authors.create');
    }
}