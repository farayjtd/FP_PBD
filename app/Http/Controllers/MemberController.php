<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $filter = $request->filter;

        $query = Member::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('joined', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if ($filter == 'active_latest') {
            $query->where('status', 'active')->orderBy('joined', 'desc');
        } elseif ($filter == 'active_oldest') {
            $query->where('status', 'active')->orderBy('joined', 'asc');
        } elseif ($filter == 'inactive_latest') {
            $query->where('status', 'inactive')->orderBy('joined', 'desc');
        } elseif ($filter == 'inactive_oldest') {
            $query->where('status', 'inactive')->orderBy('joined', 'asc');
        } elseif ($filter == 'all_oldest') {
            $query->orderBy('joined', 'asc');
        } else {
            $query->orderBy('joined', 'desc');
        }

        $members = $query->get();

        return view('member.index', compact('members', 'search', 'filter'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        Member::create($request->all());
        return redirect()->route('member.index');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());
        return redirect()->route('member.index');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        $hasUnreturned = $member->borrowings()->where('status', 'borrowed')->exists();

        if ($hasUnreturned) {
            return redirect()->route('member.index')
                ->with('error', 'Tidak dapat menghapus member. Masih ada buku yang belum dikembalikan.');
        }

        $member->borrowings()->delete(); 

        $member->delete();

        return redirect()->route('member.index')
            ->with('success', 'Member berhasil dihapus.');
    }
}
