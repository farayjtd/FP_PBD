@extends('layout')

@if(session('error'))
    <div style="background-color: #ffe5e5; padding: 10px; border: 1px solid red; color: red; border-radius: 5px; margin-bottom: 15px;">
        <strong>Peringatan:</strong> {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div style="background-color: #e5ffea; padding: 10px; border: 1px solid green; color: green; border-radius: 5px; margin-bottom: 15px;">
        <strong>Berhasil:</strong> {{ session('success') }}
    </div>
@endif

@section('content')
    <h3 style="color: #1e88e5;">Book List</h3>
    <a href="{{ route('book.create') }}" class="btn-blue">+ Add New Book</a>

    <form method="GET" action="{{ route('book.index') }}" id="filterForm" style="margin: 20px 0;">
        <input type="text" name="search" placeholder="Search by title, author, ISBN, publisher"
               value="{{ request('search') }}" onkeydown="if(event.key === 'Enter') this.form.submit();">

        <select name="sort" onchange="document.getElementById('filterForm').submit();">
            <option value="">-- Sort By --</option>
            <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Tahun Terbaru</option>
            <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Tahun Terlama</option>
            <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stok Terbanyak</option>
            <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stok Tersedikit</option>
        </select>
    </form>

    @if($books->isEmpty())
        <p><strong>Data tidak ditemukan.</strong></p>
    @else
    <table class="book-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->publisher->name }}</td>
                    <td>{{ $book->year }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->stock }}</td>
                    <td>
                        <button class="btn-detail" onclick="showDetail({{ $book->id }})">Detail</button>
                        <button class="btn-edit" onclick="showEdit({{ $book->id }})">Edit</button>
                        <form action="{{ route('book.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>

                <div id="detail-modal-{{ $book->id }}" class="modal">
                    <div class="modal-content">
                        <h4>Book Detail</h4>
                        <p><strong>Title:</strong> {{ $book->title }}</p>
                        <p><strong>Author:</strong> {{ $book->author }}</p>
                        <p><strong>Publisher:</strong> {{ $book->publisher->name }}</p>
                        <p><strong>Year:</strong> {{ $book->year }}</p>
                        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                        <p><strong>Stock:</strong> {{ $book->stock }}</p>
                        <p><strong>Categories:</strong> {{ $book->categories->pluck('name')->join(', ') }}</p>
                        <p><strong>Detail:</strong></p>
                        @if ($book->detail)
                        <ul>
                            <li>Shelf Code: {{ $book->detail->shelf_code }}</li>
                            <li>Pages: {{ $book->detail->pages }}</li>
                            <li>Weight: {{ $book->detail->weight }}</li>
                            <li>Language: {{ $book->detail->language }}</li>
                            <li>Size: {{ $book->detail->size }}</li>
                            <li>Condition: {{ $book->detail->book_condition }}</li>
                        </ul>
                        @else
                            <p><em>Detail buku belum tersedia.</em></p>
                        @endif

                        <button onclick="hideDetail({{ $book->id }})" class="btn-close">Close</button>
                    </div>
                </div>

                <div id="edit-modal-{{ $book->id }}" class="modal">
                    <div class="modal-content">
                        <h4>Edit Book</h4>
                        <form action="{{ route('book.update', $book->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <p>Title: <input type="text" name="title" value="{{ $book->title }}"></p>
                            <p>Author: <input type="text" name="author" value="{{ $book->author }}"></p>
                            <p>Publisher:
                                <select name="publisher_id">
                                    @foreach($publishers as $publisher)
                                        <option value="{{ $publisher->id }}" {{ $book->publisher_id == $publisher->id ? 'selected' : '' }}>
                                            {{ $publisher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </p>
                            <p>Year: <input type="number" name="year" value="{{ $book->year }}"></p>
                            <p>ISBN: <input type="text" name="isbn" value="{{ $book->isbn }}"></p>
                            <p>Stock: <input type="number" name="stock" value="{{ $book->stock }}"></p>

                            <p>Categories:</p>
                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                @foreach($categories as $cat)
                                    <label style="display: flex; align-items: center;">
                                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                                            {{ $book->categories->contains($cat->id) ? 'checked' : '' }}>
                                        <span style="margin-left: 5px;">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <hr>
                            <p>Shelf Code: <input type="text" name="shelf_code" value="{{ $book->detail->shelf_code ?? '' }}"></p>
                            <p>Weight: <input type="number" name="weight" value="{{ $book->detail->weight ?? '' }}"></p>
                            <p>Language: <input type="text" name="language" value="{{ $book->detail->language ?? '' }}"></p>
                            <p>Size: <input type="text" name="size" value="{{ $book->detail->size ?? '' }}"></p>
                            <p>Condition:
                                <select name="book_condition">
                                    <option value="">-- Pilih --</option>
                                    <option value="baru" {{ ($book->detail->book_condition ?? '') == 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="bekas" {{ ($book->detail->book_condition ?? '') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                                </select>
                            </p>
                            <button type="submit" class="btn-blue">Update</button>
                            <button type="button" onclick="hideEdit({{ $book->id }})" class="btn-close">Cancel</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    @endif

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
    .btn-blue {
        background-color: #1e88e5;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-blue:hover { background-color: #1565c0; }
    .btn-detail, .btn-edit, .btn-delete, .btn-close {
        margin: 2px;
        padding: 5px 10px;
        font-size: 0.9rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-detail { background-color: #42a5f5; color: white; }
    .btn-edit { background-color: #4caf50; color: white; }
    .btn-delete { background-color: #e53935; color: white; }
    .btn-close { background-color: #757575; color: white; }
    .btn-detail:hover { background-color: #1e88e5; }
    .btn-edit:hover { background-color: #388e3c; }
    .btn-delete:hover { background-color: #c62828; }
    .btn-close:hover { background-color: #616161; }
    .book-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .book-table th, .book-table td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }
    .modal {
        display: none;
        position: fixed;
        top: 5%;
        left: 50%;
        transform: translateX(-50%);
        background-color: white;
        border: 1px solid #ddd;
        padding: 20px;
        z-index: 1000;
        width: 60%;
        max-width: 600px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        border-radius: 8px;
    }
    .modal-content h4 {
        margin-top: 0;
        color: #1e88e5;
    }
    .modal-content p, .modal-content ul {
        margin-bottom: 10px;
        color: #333;
    }
    .modal-content input, .modal-content select {
        width: 100%;
        padding: 6px;
        margin-bottom: 10px;
    }
</style>
@endpush
