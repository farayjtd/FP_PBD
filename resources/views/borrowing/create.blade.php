@extends('layout')

@section('content')
    <div class="container">
        {{-- Alert --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Tambah Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('borrowing.store') }}" method="POST">
                            @csrf

                            {{-- Pilih Member --}}
                            <div class="mb-3">
                                <label for="member_id" class="form-label">Member <span class="text-danger">*</span></label>
                                <select name="member_id" id="member_id" class="form-select" required>
                                    <option value="">-- Pilih Member --</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pilih Buku --}}
                            <div class="mb-3">
                                <label for="book_id" class="form-label">Buku <span class="text-danger">*</span></label>
                                <select name="book_id" id="book_id" class="form-select" required>
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('book_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Pinjam --}}
                            <div class="mb-3">
                                <label for="borrowed" class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                                <input type="date" name="borrowed" id="borrowed" class="form-control" 
                                       value="{{ old('borrowed') }}" required>
                                @error('borrowed')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Kembali --}}
                            <div class="mb-3">
                                <label for="returned" class="form-label">Tanggal Kembali</label>
                                <input type="date" name="returned" id="returned" class="form-control" 
                                       value="{{ old('returned') }}">
                                <div class="form-text">Kosongkan jika belum dikembalikan</div>
                                @error('returned')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="borrowed" {{ old('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="returned" {{ old('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Form Actions --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('borrowing.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection