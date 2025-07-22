@extends('layout')

@section('content')
    <div class="container">
        <h3 class="text-primary mb-3">Member List</h3>

        {{-- Alert --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Add Button & Search --}}
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('member.create') }}" class="btn btn-primary">+ Tambah Member Baru</a>

            <form method="GET" action="{{ route('member.index') }}" class="d-flex">
                <input type="text" name="search" placeholder="Search..." class="form-control me-2"
                    value="{{ request('search') }}">
                <select name="filter" class="form-select me-2" onchange="this.form.submit()">
                    <option value="">-- All Status & Order --</option>
                    <option value="active_oldest" {{ request('filter') == 'active_oldest' ? 'selected' : '' }}>Active - Oldest</option>
                    <option value="active_newest" {{ request('filter') == 'active_newest' ? 'selected' : '' }}>Active - Newest</option>
                    <option value="inactive_oldest" {{ request('filter') == 'inactive_oldest' ? 'selected' : '' }}>Inactive - Oldest</option>
                    <option value="inactive_newest" {{ request('filter') == 'inactive_newest' ? 'selected' : '' }}>Inactive - Newest</option>
                </select>
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </form>
        </div>

        {{-- Member Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $index => $member)
                        <tr class="text-center">
                            <td>{{ $members->firstItem() + $index }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>
                                <span class="badge {{ $member->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $member->id }}">Detail</button>

                                <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $member->id }}">Edit</button>

                                <form action="{{ route('member.destroy', $member->id) }}" method="POST"
                                    style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Detail Modal --}}
                        <div class="modal fade" id="detailModal{{ $member->id }}" tabindex="-1" aria-labelledby="detailLabel{{ $member->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="detailLabel{{ $member->id }}">Member Detail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nama:</strong> {{ $member->name }}</p>
                                        <p><strong>Email:</strong> {{ $member->email }}</p>
                                        <p><strong>Telepon:</strong> {{ $member->phone }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($member->status) }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1" aria-labelledby="editLabel{{ $member->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('member.update', $member->id) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title" id="editLabel{{ $member->id }}">Edit Member</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label>Nama</label>
                                                <input type="text" name="name" value="{{ $member->name }}" class="form-control" required>
                                            </div>
                                            <div class="mb-2">
                                                <label>Email</label>
                                                <input type="email" name="email" value="{{ $member->email }}" class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label>Telepon</label>
                                                <input type="text" name="phone" value="{{ $member->phone }}" class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                            <td colspan="6" class="text-center text-danger">Data member tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $members->links() }}
            </div>
        </div>
    </div>
@endsection