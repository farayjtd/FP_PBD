@extends('layout')

@section('content')
    <div class="container">
        <h3 class="text-primary mb-3">Book List</h3>

        {{-- Alert --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Add Button & Search --}}
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('book.create') }}" class="btn btn-primary">+ Add New Book</a>

            <form method="GET" action="{{ route('book.index') }}" class="d-flex">
                <input type="text" name="search" placeholder="Search by title, author, ISBN, publisher"
                       value="{{ request('search') }}" class="form-control me-2">
                <select name="sort" class="form-select me-2" onchange="this.form.submit()">
                    <option value="">-- Sort By --</option>
                    <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Tahun Terbaru</option>
                    <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Tahun Terlama</option>
                    <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stok Terbanyak</option>
                    <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stok Tersedikit</option>
                </select>
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </form>
        </div>

        {{-- Book Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Tahun</th>
                        <th>ISBN</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                        <tr class="text-center">
                            <td>{{ $books->firstItem() + $index }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher->name }}</td>
                            <td>{{ $book->year }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->stock }}</td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" 
                                        data-bs-target="#detailModal{{ $book->id }}">Detail</button>
                                <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" 
                                        data-bs-target="#editModal{{ $book->id }}">Edit</button>
                                <form action="{{ route('book.destroy', $book->id) }}" method="POST" 
                                      style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Detail Modal --}}
                        <div class="modal fade" id="detailModal{{ $book->id }}" tabindex="-1" 
                             aria-labelledby="detailLabel{{ $book->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="detailLabel{{ $book->id }}">Detail Buku</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Judul:</strong> {{ $book->title }}</p>
                                                <p><strong>Author:</strong> {{ $book->author }}</p>
                                                <p><strong>Publisher:</strong> {{ $book->publisher->name }}</p>
                                                <p><strong>Tahun:</strong> {{ $book->year }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                                <p><strong>Stok:</strong> {{ $book->stock }}</p>
                                                <p><strong>Kategori:</strong> {{ $book->categories->pluck('name')->join(', ') }}</p>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        <h6 class="text-primary">Book Details:</h6>
                                        @if ($book->detail)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Shelf Code:</strong> {{ $book->detail->shelf_code }}</p>
                                                    <p><strong>Pages:</strong> {{ $book->detail->pages }}</p>
                                                    <p><strong>Weight:</strong> {{ $book->detail->weight }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Language:</strong> {{ $book->detail->language }}</p>
                                                    <p><strong>Size:</strong> {{ $book->detail->size }}</p>
                                                    <p><strong>Condition:</strong> {{ $book->detail->book_condition }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-muted"><em>Detail buku belum tersedia.</em></p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $book->id }}" tabindex="-1" 
                             aria-labelledby="editLabel{{ $book->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('book.update', $book->id) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title" id="editLabel{{ $book->id }}">Edit Buku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul</label>
                                                        <input type="text" name="title" value="{{ $book->title }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Author</label>
                                                        <input type="text" name="author" value="{{ $book->author }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Publisher</label>
                                                        <select name="publisher_id" class="form-select" required>
                                                            @foreach($publishers as $publisher)
                                                                <option value="{{ $publisher->id }}" {{ $book->publisher_id == $publisher->id ? 'selected' : '' }}>
                                                                    {{ $publisher->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tahun</label>
                                                        <input type="number" name="year" value="{{ $book->year }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">ISBN</label>
                                                        <input type="text" name="isbn" value="{{ $book->isbn }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Stok</label>
                                                        <input type="number" name="stock" value="{{ $book->stock }}" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($categories as $cat)
                                                        <div class="form-check">
                                                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                                                                class="form-check-input" id="cat{{ $cat->id }}_{{ $book->id }}"
                                                                {{ $book->categories->contains($cat->id) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="cat{{ $cat->id }}_{{ $book->id }}">
                                                                {{ $cat->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <hr>
                                            <h6 class="text-primary">Detail Buku</h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kode Rak</label>
                                                        <input type="text" name="shelf_code" value="{{ $book->detail->shelf_code ?? '' }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Berat</label>
                                                        <input type="number" name="weight" value="{{ $book->detail->weight ?? '' }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Bahasa</label>
                                                        <input type="text" name="language" value="{{ $book->detail->language ?? '' }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Ukuran</label>
                                                        <input type="text" name="size" value="{{ $book->detail->size ?? '' }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kondisi</label>
                                                        <select name="book_condition" class="form-select">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="new" {{ ($book->detail->book_condition ?? '') == 'new' ? 'selected' : '' }}>Baru</option>
                                                            <option value="used" {{ ($book->detail->book_condition ?? '') == 'used' ? 'selected' : '' }}>Bekas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Perbarui</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-danger">Data buku tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection