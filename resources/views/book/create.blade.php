@extends('layout')

@section('content')
    <h2 style="color: #1e88e5; margin-bottom: 20px;">Tambah Buku</h2>

    <form action="{{ route('book.store') }}" method="POST" class="book-form">
        @csrf

        {{-- Informasi Buku --}}
        <div class="form-group">
            <label>Judul Buku:</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Penulis:</label>
            <input type="text" name="author" required>
        </div>

        <div class="form-group">
            <label>Publisher:</label>
            <select name="publisher_id" required>
                <option value="">-- Pilih Publisher --</option>
                @foreach ($publishers as $publisher)
                    <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Tahun Terbit:</label>
            <input type="number" name="year" required>
        </div>

        <div class="form-group">
            <label>ISBN:</label>
            <input type="text" name="isbn">
        </div>

        <div class="form-group">
            <label>Stok:</label>
            <input type="number" name="stock" min="0" value="0" required>
        </div>

        <div class="form-group">
            <label>Kategori:</label>
            <div class="checkbox-group">
                @foreach($categories as $cat)
                    <label>
                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}">
                        {{ $cat->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <hr style="margin: 30px 0;">

        <h4 style="color: #1e88e5;">Detail Buku</h4>

        <div class="form-group">
            <label>Kode Rak:</label>
            <input type="text" name="shelf_code">
        </div>

        <div class="form-group">
            <label>Jumlah Halaman:</label>
            <input type="number" name="pages">
        </div>

        <div class="form-group">
            <label>Berat (gram):</label>
            <input type="number" name="weight">
        </div>

        <div class="form-group">
            <label>Bahasa:</label>
            <input type="text" name="language">
        </div>

        <div class="form-group">
            <label>Ukuran:</label>
            <input type="text" name="size">
        </div>

        <div class="form-group">
            <label>Kondisi Buku:</label>
            <select name="book_condition">
                <option value="">-- Pilih --</option>
                <option value="baru">Baru</option>
                <option value="bekas">Bekas</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit">Simpan</button>
            <a href="{{ route('book.index') }}">Kembali</a>
        </div>
    </form>
@endsection

@push('styles')
<style>
    .book-form {
        max-width: 650px;
        margin: auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .checkbox-group label {
        display: flex;
        align-items: center;
        gap: 5px;
        background: #eee;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .form-actions {
        margin-top: 25px;
        display: flex;
        gap: 10px;
    }

    .form-actions button,
    .form-actions a {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
    }

    .form-actions button {
        background-color: #1e88e5;
        color: white;
        cursor: pointer;
    }

    .form-actions a {
        background-color: #e0e0e0;
        color: #333;
    }

    .form-actions button:hover {
        background-color: #1565c0;
    }

    .form-actions a:hover {
        background-color: #bdbdbd;
    }
</style>
@endpush
