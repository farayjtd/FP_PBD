@extends('layout')

@section('content')
    <h2 class="text-center mb-4">Dashboard Perpustakaan</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card text-bg-light h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Buku</h5>
                    <p class="card-text fs-4">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-bg-light h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Publisher</h5>
                    <p class="card-text fs-4">{{ $totalPublishers }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-bg-light h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Member</h5>
                    <p class="card-text fs-4">{{ $totalMembers }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-bg-light h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Kategori</h5>
                    <p class="card-text fs-4">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-bg-light h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Buku Dipinjam</h5>
                    <p class="card-text fs-4">{{ $totalBorrowed }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-bg-light h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Buku Dikembalikan</h5>
                    <p class="card-text fs-4">{{ $totalReturned }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
