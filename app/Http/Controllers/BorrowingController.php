<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['book', 'member']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            if (in_array($request->status, ['borrowed', 'returned'])) {
                $query->where('status', $request->status);
            }
        }

        $borrowings = $query->get();
        $members = Member::all();
        $books = Book::all();

        $borrowings = $query->paginate(10)->withQueryString();

        return view('borrowing.index', compact('borrowings', 'members', 'books'));
    }

    public function create()
    {
        $books = Book::all();
        $members = Member::all();
        return view('borrowing.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        Borrowing::create($request->all());
        return redirect()->route('borrowing.index');
    }

    public function edit($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $books = Book::all();
        $members = Member::all();
        return view('borrowing.edit', compact('borrowing', 'books', 'members'));
    }

    public function update(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update($request->all());
        return redirect()->route('borrowing.index');
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status === 'borrowed') {
            return redirect()->back()->with('error', 'Data peminjaman belum dikembalikan, tidak dapat dihapus.');
        }

        $borrowing->delete();

        return redirect()->route('borrowing.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
