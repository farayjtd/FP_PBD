<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookDetail;
use Illuminate\Http\Request;

class BookDetailController extends Controller
{
    public function index()
    {
        $details = BookDetail::with('book')->get();
        return view('book_detail.index', compact('details'));
    }

    public function create()
    {
        $books = Book::doesntHave('detail')->get(); 
        return view('book_detail.create', compact('books'));
    }

    public function store(Request $request)
    {
        BookDetail::create($request->all());
        return redirect()->route('book-detail.index');
    }

    public function edit($id)
    {
        $detail = BookDetail::findOrFail($id);
        return view('book_detail.edit', compact('detail'));
    }

    public function update(Request $request, $id)
    {
        BookDetail::findOrFail($id)->update($request->all());
        return redirect()->route('book-detail.index');
    }

    public function destroy($id)
    {
        BookDetail::destroy($id);
        return redirect()->route('book-detail.index');
    }
}
