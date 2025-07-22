@extends('layout')

@section('content')
    <div class="container">
        <h3 class="text-primary mb-3">Publisher List</h3>

        {{-- Alert --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Add Button & Search --}}
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('publisher.create') }}" class="btn btn-primary">+ Tambah Publisher</a>

            <form method="GET" action="{{ route('publisher.index') }}" class="d-flex">
                <input type="text" name="search" placeholder="Search..." class="form-control me-2"
                    value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </form>
        </div>

        {{-- Publisher Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($publishers as $index => $publisher)
                        <tr class="text-center">
                            <td>{{ $publishers->firstItem() + $index }}</td>
                            <td>{{ $publisher->name }}</td>
                            <td>{{ $publisher->phone }}</td>
                            <td>{{ $publisher->email }}</td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $publisher->id }}">Detail</button>

                                <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $publisher->id }}">Edit</button>

                                <form action="{{ route('publisher.destroy', $publisher->id) }}" method="POST"
                                    style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Detail Modal --}}
                        <div class="modal fade" id="detailModal{{ $publisher->id }}" tabindex="-1" aria-labelledby="detailLabel{{ $publisher->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="detailLabel{{ $publisher->id }}">Publisher Detail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nama:</strong> {{ $publisher->name }}</p>
                                        <p><strong>Alamat:</strong> {{ $publisher->address }}</p>
                                        <p><strong>Telepon:</strong> {{ $publisher->phone }}</p>
                                        <p><strong>Email:</strong> {{ $publisher->email }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $publisher->id }}" tabindex="-1" aria-labelledby="editLabel{{ $publisher->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('publisher.update', $publisher->id) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title" id="editLabel{{ $publisher->id }}">Edit Publisher</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label>Nama</label>
                                                <input type="text" name="name" value="{{ $publisher->name }}" class="form-control" required>
                                            </div>
                                            <div class="mb-2">
                                                <label>Alamat</label>
                                                <input type="text" name="address" value="{{ $publisher->address }}" class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label>Telepon</label>
                                                <input type="text" name="phone" value="{{ $publisher->phone }}" class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label>Email</label>
                                                <input type="email" name="email" value="{{ $publisher->email }}" class="form-control">
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
                            <td colspan="5" class="text-center text-danger">Data publisher tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $publishers->links() }}
            </div>
        </div>
    </div>
@endsection
