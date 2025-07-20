@extends('layout')

@section('content')
    <div class="container">
        <h3 class="text-primary mb-3">Category List</h3>

        {{-- Alert --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Add Button & Search --}}
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('category.create') }}" class="btn btn-primary">+ Add New Category</a>

            <form method="GET" action="{{ route('category.index') }}" class="d-flex">
                <input type="text" name="search" placeholder="Search..." class="form-control me-2"
                    value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>

        {{-- Category Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $category)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $category->id }}">Detail</button>

                                <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $category->id }}">Edit</button>

                                <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                    style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Detail Modal --}}
                        <div class="modal fade" id="detailModal{{ $category->id }}" tabindex="-1" aria-labelledby="detailLabel{{ $category->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="detailLabel{{ $category->id }}">Category Detail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Name:</strong> {{ $category->name }}</p>
                                        <p><strong>Slug:</strong> {{ $category->slug }}</p>
                                        <p><strong>Created:</strong> {{ $category->created_at }}</p>
                                        <p><strong>Updated:</strong> {{ $category->updated_at }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" aria-labelledby="editLabel{{ $category->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('category.update', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title" id="editLabel{{ $category->id }}">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label>Name</label>
                                                <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                                            </div>
                                            <div class="mb-2">
                                                <label>Slug</label>
                                                <input type="text" name="slug" value="{{ $category->slug }}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Update</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-danger">Data kategori tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection