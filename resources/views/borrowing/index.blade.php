@extends('layout')
@if (session('success'))
    <div style="background-color: #d4edda; padding: 10px; border: 1px solid #c3e6cb; margin: 10px 0;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="background-color: #f8d7da; padding: 10px; border: 1px solid #f5c6cb; margin: 10px 0;">
        {{ session('error') }}
    </div>
@endif

@section('content')
    <div class="container">
        <h3 class="title">Daftar Peminjaman</h3>
        <a href="{{ route('borrowing.create') }}" class="btn-primary">+ Tambah Peminjaman</a>

        {{-- Search dan Filter --}}
        <form method="GET" action="{{ route('borrowing.index') }}" style="margin: 15px 0;">
            <input type="text" name="search" placeholder="Cari nama atau judul buku..." 
                   value="{{ request('search') }}" 
                   onkeydown="if(event.key === 'Enter') this.form.submit();" 
                   style="padding: 8px; width: 300px;">

            <select name="status" onchange="this.form.submit()" style="padding: 8px;">
                <option value="">Semua Status</option>
                <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
        </form>

        {{-- Tampilkan jika kosong --}}
        @if($borrowings->isEmpty())
            <p style="color: gray;">Data peminjaman tidak ditemukan.</p>
        @else
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Member</th>
                        <th>Buku</th>
                        <th>Dipinjam</th>
                        <th>Dikembalikan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $borrowing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $borrowing->member->name ?? 'N/A' }}</td>
                            <td>{{ $borrowing->book->title ?? 'N/A' }}</td>
                            <td>{{ $borrowing->borrowed }}</td>
                            <td>{{ $borrowing->returned ?? '-' }}</td>
                            <td>{{ ucfirst($borrowing->status) }}</td>
                            <td>
                                <button class="btn-secondary" onclick="showDetail({{ $borrowing->id }})">Detail</button>
                                <button class="btn-secondary" onclick="showEdit({{ $borrowing->id }})">Edit</button>
                                <form action="{{ route('borrowing.destroy', $borrowing->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Detail --}}
                        <div id="detail-modal-{{ $borrowing->id }}" class="modal">
                            <div class="modal-content">
                                <h4>Detail Peminjaman</h4>
                                <p><strong>Member:</strong> {{ $borrowing->member->name ?? '-' }}</p>
                                <p><strong>Buku:</strong> {{ $borrowing->book->title ?? '-' }}</p>
                                <p><strong>Dipinjam:</strong> {{ $borrowing->borrowed }}</p>
                                <p><strong>Dikembalikan:</strong> {{ $borrowing->returned ?? '-' }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($borrowing->status) }}</p>
                                <p><strong>Dibuat:</strong> {{ $borrowing->created_at }}</p>
                                <p><strong>Update Terakhir:</strong> {{ $borrowing->updated_at }}</p>
                                <button class="btn-secondary" onclick="hideDetail({{ $borrowing->id }})">Tutup</button>
                            </div>
                        </div>

                        {{-- Modal Edit --}}
                        <div id="edit-modal-{{ $borrowing->id }}" class="modal">
                            <div class="modal-content">
                                <h4>Edit Peminjaman</h4>
                                <form action="{{ route('borrowing.update', $borrowing->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <label>Member:</label>
                                    <select name="member_id" required>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->id }}" 
                                                {{ $borrowing->member_id == $member->id ? 'selected' : '' }}>
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label>Buku:</label>
                                    <select name="book_id" required>
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id }}" 
                                                {{ $borrowing->book_id == $book->id ? 'selected' : '' }}>
                                                {{ $book->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label>Tanggal Pinjam:</label>
                                    <input type="date" name="borrowed" value="{{ $borrowing->borrowed }}">

                                    <label>Tanggal Kembali:</label>
                                    <input type="date" name="returned" value="{{ $borrowing->returned }}">

                                    <label>Status:</label>
                                    <select name="status">
                                        <option value="borrowed" {{ $borrowing->status == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="returned" {{ $borrowing->status == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                                    </select>

                                    <button class="btn-primary" type="submit">Update</button>
                                    <button class="btn-secondary" type="button" onclick="hideEdit({{ $borrowing->id }})">Batal</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        function showDetail(id) {
            document.getElementById('detail-modal-' + id).style.display = 'block';
        }

        function hideDetail(id) {
            document.getElementById('detail-modal-' + id).style.display = 'none';
        }

        function showEdit(id) {
            document.getElementById('edit-modal-' + id).style.display = 'block';
        }

        function hideEdit(id) {
            document.getElementById('edit-modal-' + id).style.display = 'none';
        }
    </script>
@endsection

@push('styles')
    <style>
        body {
            background: #fff;
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 30px;
            max-width: 1000px;
            margin: auto;
        }

        .title {
            font-size: 24px;
            margin-bottom: 15px;
            color: #0d47a1;
        }

        .btn-primary,
        .btn-secondary,
        .btn-danger {
            display: inline-block;
            padding: 6px 12px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #0d47a1;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1565c0;
        }

        .btn-secondary {
            background-color: #e3f2fd;
            color: #0d47a1;
        }

        .btn-secondary:hover {
            background-color: #bbdefb;
        }

        .btn-danger {
            background-color: #c62828;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b71c1c;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .styled-table th,
        .styled-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .styled-table th {
            background-color: #0d47a1;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            border: 1px solid #ccc;
            padding: 25px;
            z-index: 999;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .modal-content label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 7px;
            margin-bottom: 10px;
        }

        .modal-content h4 {
            margin-top: 0;
            color: #0d47a1;
        }
    </style>
@endpush
