@extends('layout')

@section('content')
    <h2 style="text-align:center; margin-bottom:20px;">Dashboard Perpustakaan</h2>

    <div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:center;">
        <div class="card">
            <h4>Jumlah Buku</h4>
            <p>{{ $totalBooks }}</p>
        </div>
        <div class="card">
            <h4>Jumlah Publisher</h4>
            <p>{{ $totalPublishers }}</p>
        </div>
        <div class="card">
            <h4>Jumlah Member</h4>
            <p>{{ $totalMembers }}</p>
        </div>
        <div class="card">
            <h4>Jumlah Kategori</h4>
            <p>{{ $totalCategories }}</p>
        </div>
        <div class="card">
            <h4>Buku Dipinjam</h4>
            <p>{{ $totalBorrowed }}</p>
        </div>
        <div class="card">
            <h4>Buku Dikembalikan</h4>
            <p>{{ $totalReturned }}</p>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        width: 200px;
        padding: 20px;
        border-radius: 10px;
        background-color: #f5f5f5;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: 0.3s;
    }

    .card:hover {
        background-color: #e0f7fa;
        transform: translateY(-5px);
    }

    .card h4 {
        margin-bottom: 10px;
        color: #1e88e5;
    }

    .card p {
        font-size: 1.5em;
        color: #333;
        margin: 0;
    }
</style>
@endpush
