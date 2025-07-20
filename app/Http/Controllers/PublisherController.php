<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $query = Publisher::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        $publishers = $query->get();

        return view('publisher.index', compact('publishers'));
    }

    public function create()
    {
        return view('publisher.create');
    }

    public function store(Request $request)
    {
        Publisher::create($request->all());
        return redirect()->route('publisher.index');
    }

    public function edit($id)
    {
        $publisher = Publisher::findOrFail($id);
        return view('publisher.edit', compact('publisher'));
    }

    public function update(Request $request, $id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->update($request->all());
        return redirect()->route('publisher.index');
    }

    public function destroy($id)
    {
        $publisher = Publisher::findOrFail($id);

        if ($publisher->books()->count() > 0) {
            return redirect()->route('publisher.index')->with('error', 'Tidak bisa dihapus karena masih ada buku yang terkait.');
        }

        $publisher->delete();
        return redirect()->route('publisher.index')->with('success', 'Data berhasil dihapus.');
    }
}
