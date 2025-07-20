@extends('layout')

@section('content')
    <h2>Tambah Kategori</h2>

    <form action="{{ route('category.store') }}" method="POST">
        @csrf

        <p>Nama Kategori:
            <input type="text" name="name" required>
        </p>

        <p>Slug:
            <input type="text" name="slug" required>
        </p>

        <button type="submit">Simpan</button>
        <a href="{{ route('category.index') }}">Kembali</a>
    </form>
@endsection
