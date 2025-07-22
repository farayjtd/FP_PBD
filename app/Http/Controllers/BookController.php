<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookDetail;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('publisher', 'categories', 'detail');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('author', 'like', "%$search%")
                ->orWhere('isbn', 'like', "%$search%")
                ->orWhereHas('publisher', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                });
            });
        }

        switch ($request->sort) {
            case 'year_desc':
                $query->orderBy('year', 'desc');
                break;
            case 'year_asc':
                $query->orderBy('year', 'asc');
                break;
            case 'stock_desc':
                $query->orderBy('stock', 'desc');
                break;
            case 'stock_asc':
                $query->orderBy('stock', 'asc');
                break;
            default:
                $query->orderBy('title', 'asc');
                break;
        }

        $books = $query->get();
        $publishers = Publisher::all();  
        $categories = Category::all();    

        $books = $query->paginate(10)->withQueryString();

        return view('book.index', compact('books', 'publishers', 'categories'));
    }

    public function create()
    {
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('book.create', compact('publishers', 'categories'));
    }

    public function store(Request $request)
    {
        $book = Book::create($request->only(['title', 'author', 'publisher_id', 'year', 'isbn', 'stock']));

        BookDetail::create(array_merge($request->only([
            'shelf_code', 'pages', 'weight', 'language', 'size', 'book_condition'
        ]), 
        [ 'book_id' => $book->id]));

        if ($request->has('category_ids')) {
            $book->categories()->sync($request->category_ids);
        }

        return redirect()->route('book.index')->with('success', 'Buku berhasil ditambahkan beserta detailnya.');
    }

    public function edit($id)
    {
        $book = Book::with('detail', 'categories')->findOrFail($id);
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('book.edit', compact('book', 'publishers', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->only(['title', 'author', 'publisher_id', 'year', 'isbn', 'stock']));
        $book->detail->update($request->only(['shelf_code', 'pages', 'weight', 'language', 'size', 'book_condition']));
        $book->categories()->sync($request->category_ids);
        return redirect()->route('book.index');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $borrowed = Borrowing::where('book_id', $id)->where('status', 'borrowed')->exists();

        if ($borrowed) {
            return redirect()->back()->with('error', 'Buku sedang dipinjam dan tidak dapat dihapus.');
        }

        try {
            if ($book->detail) {
                $book->detail->delete();
            }

            $book->categories()->detach();

            $book->delete();

            return redirect()->route('book.index')->with('success', 'Buku berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('book.index')->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }
}
