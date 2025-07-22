@extends('layout')

@section('content')
    <div class="container">
        <h3 class="text-primary mb-3">Daftar Peminjaman</h3>

        {{-- Alert --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Add Button & Search --}}
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('borrowing.create') }}" class="btn btn-primary">+ Tambah Peminjaman</a>

            <form method="GET" action="{{ route('borrowing.index') }}" class="d-flex">
                <input type="text" name="search" placeholder="Cari nama atau judul buku..." 
                       value="{{ request('search') }}" class="form-control me-2">
                <select name="status" class="form-select me-2" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </form>
        </div>

        {{-- Borrowing Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
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
                    @forelse($borrowings as $index => $borrowing)
                        <tr class="text-center">
                            <td>{{ $borrowings->firstItem() + $index }}</td>
                            <td>{{ $borrowing->member->name ?? 'N/A' }}</td>
                            <td>{{ $borrowing->book->title ?? 'N/A' }}</td>
                            <td>{{ $borrowing->borrowed }}</td>
                            <td>{{ $borrowing->returned ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $borrowing->status == 'returned' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($borrowing->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" 
                                        data-bs-target="#detailModal{{ $borrowing->id }}">Detail</button>
                                <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" 
                                        data-bs-target="#editModal{{ $borrowing->id }}">Edit</button>
                                <form action="{{ route('borrowing.destroy', $borrowing->id) }}" method="POST" 
                                      style="display:inline-block;" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Detail Modal --}}
                        <div class="modal fade" id="detailModal{{ $borrowing->id }}" tabindex="-1" 
                             aria-labelledby="detailLabel{{ $borrowing->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="detailLabel{{ $borrowing->id }}">Detail Peminjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Member:</strong> {{ $borrowing->member->name ?? '-' }}</p>
                                        <p><strong>Buku:</strong> {{ $borrowing->book->title ?? '-' }}</p>
                                        <p><strong>Dipinjam:</strong> {{ $borrowing->borrowed }}</p>
                                        <p><strong>Dikembalikan:</strong> {{ $borrowing->returned ?? '-' }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($borrowing->status) }}</p>
                                        <p><strong>Dibuat:</strong> {{ $borrowing->created_at }}</p>
                                        <p><strong>Update Terakhir:</strong> {{ $borrowing->updated_at }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $borrowing->id }}" tabindex="-1" 
                             aria-labelledby="editLabel{{ $borrowing->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('borrowing.update', $borrowing->id) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title" id="editLabel{{ $borrowing->id }}">Edit Peminjaman</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label class="form-label">Member</label>
                                                <select name="member_id" class="form-control" required>
                                                    @foreach ($members as $member)
                                                        <option value="{{ $member->id }}" 
                                                            {{ $borrowing->member_id == $member->id ? 'selected' : '' }}>
                                                            {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Buku</label>
                                                <select name="book_id" class="form-control" required>
                                                    @foreach ($books as $book)
                                                        <option value="{{ $book->id }}" 
                                                            {{ $borrowing->book_id == $book->id ? 'selected' : '' }}>
                                                            {{ $book->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Tanggal Pinjam</label>
                                                <input type="date" name="borrowed" value="{{ $borrowing->borrowed }}" class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Tanggal Kembali</label>
                                                <input type="date" name="returned" value="{{ $borrowing->returned }}" class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="borrowed" {{ $borrowing->status == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                                    <option value="returned" {{ $borrowing->status == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                                                </select>
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
                            <td colspan="7" class="text-center text-danger">Data peminjaman tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $borrowings->links() }}
            </div>
        </div>
    </div>
@endsection