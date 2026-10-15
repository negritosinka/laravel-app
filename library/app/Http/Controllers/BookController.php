<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Список книг (с поддержкой простого поиска для AJAX/обычного запроса)
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('author', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        // Если запрос пришел через AJAX, можно вернуть только html или json, 
        // но для простоты вернем обычный вид (или заменим часть страницы)
        if ($request->ajax()) {
            return view('books.partials.book-list', compact('books'))->render();
        }

        return view('books.index', compact('books'));
    }

    // Форма создания книги
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // Сохранение новой книги в БД (с валидацией)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|min:1000|max:2100',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Grāmata veiksmīgi izveidota!');
    }

    // Просмотр одной книги
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    // Форма редактирования книги
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    // Обновление книги (с валидацией)
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|min:1000|max:2100',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Grāmata veiksmīgi atjaunināta!');
    }

    // Удаление книги (поддерживает AJAX)
    public function destroy(Book $book)
    {
        $book->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Grāmata dzēsta!']);
        }

        return redirect()->route('books.index')->with('success', 'Grāmata dzēsta!');
    }
}