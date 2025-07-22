@extends('layout')

@section('content')
    <div class="container">
        <div class="card mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h3 class="card-title mb-4 text-center text-primary">Tambah Buku Baru</h3>

                <form action="{{ route('book.store') }}" method="POST">
                    @csrf

                    {{-- Basic Book Information --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" name="author" id="author" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="publisher_id" class="form-label">Publisher <span class="text-danger">*</span></label>
                                <select name="publisher_id" id="publisher_id" class="form-select" required>
                                    <option value="">-- Pilih Publisher --</option>
                                    @foreach ($publishers as $publisher)
                                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="year" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" name="year" id="year" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" name="isbn" id="isbn" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="stock" min="0" value="0" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kategori</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($categories as $cat)
                                <div class="form-check">
                                    <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" 
                                           class="form-check-input" id="category{{ $cat->id }}">
                                    <label class="form-check-label" for="category{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Book Details Section --}}
                    <h5 class="text-primary mb-3">Detail Buku</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="shelf_code" class="form-label">Kode Rak</label>
                                <input type="text" name="shelf_code" id="shelf_code" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="pages" class="form-label">Jumlah Halaman</label>
                                <input type="number" name="pages" id="pages" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="weight" class="form-label">Berat (gram)</label>
                                <input type="number" name="weight" id="weight" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="language" class="form-label">Bahasa</label>
                                <input type="text" name="language" id="language" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="size" class="form-label">Ukuran</label>
                                <input type="text" name="size" id="size" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="book_condition" class="form-label">Kondisi Buku</label>
                                <select name="book_condition" id="book_condition" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="new">Baru</option>
                                    <option value="used">Bekas</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('book.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection