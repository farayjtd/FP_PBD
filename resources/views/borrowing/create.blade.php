@extends('layout')

@section('content')
    <div class="form-container">
        <h2 class="form-title">Tambah Peminjaman</h2>

        <form action="{{ route('borrowing.store') }}" method="POST" class="styled-form">
            @csrf

            {{-- Pilih Member --}}
            <label for="member_id">Member:</label>
            <select name="member_id" required>
                <option value="">-- Pilih Member --</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>

            {{-- Pilih Buku --}}
            <label for="book_id">Buku:</label>
            <select name="book_id" required>
                <option value="">-- Pilih Buku --</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>

            {{-- Tanggal Pinjam --}}
            <label for="borrowed">Tanggal Pinjam:</label>
            <input type="date" name="borrowed" required>

            {{-- Tanggal Kembali --}}
            <label for="returned">Tanggal Kembali:</label>
            <input type="date" name="returned">

            {{-- Status --}}
            <label for="status">Status:</label>
            <select name="status" required>
                <option value="borrowed">Dipinjam</option>
                <option value="returned">Dikembalikan</option>
            </select>

            <div class="form-actions">
                <button type="submit">Simpan</button>
                <a href="{{ route('borrowing.index') }}">Kembali</a>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background-color: #ffffff;
            color: #212121;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .form-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #0d47a1; /* dark blue accent */
        }

        .styled-form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600;
        }

        .styled-form input,
        .styled-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-actions button {
            background-color: #0d47a1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-actions button:hover {
            background-color: #1565c0;
        }

        .form-actions a {
            color: #0d47a1;
            text-decoration: none;
        }

        .form-actions a:hover {
            text-decoration: underline;
        }
    </style>
@endpush
